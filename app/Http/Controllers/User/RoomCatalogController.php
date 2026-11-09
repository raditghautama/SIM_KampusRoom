<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomCatalogController extends Controller
{
    /**
     * Tampilkan katalog ruangan dengan pencarian, filter, dan status ketersediaan Real-time
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $building = $request->query('building');
        $capacity = $request->query('capacity');

        // Parameter Cek Ketersediaan Waktu (Real-time Status)
        $now = Carbon::now('Asia/Jakarta');
        $checkDate = $request->query('check_date', $now->toDateString());
        
        // Default jam pemeriksaan: waktu sekarang hingga 2 jam ke depan
        $defaultStartTime = $now->format('H:i');
        $defaultEndTime = $now->copy()->addHours(2)->format('H:i');

        $checkStartTime = $request->query('check_start_time', $defaultStartTime);
        $checkEndTime = $request->query('check_end_time', $defaultEndTime);
        $preset = $request->query('preset', 'now');

        // Sesuaikan jam berdasarkan preset jika dipilih
        if ($preset === 'morning') {
            $checkStartTime = '08:00';
            $checkEndTime = '12:00';
        } elseif ($preset === 'afternoon') {
            $checkStartTime = '13:00';
            $checkEndTime = '17:00';
        } elseif ($preset === 'evening') {
            $checkStartTime = '18:30';
            $checkEndTime = '21:30';
        }

        $query = Room::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('building', 'like', "%{$search}%")
                  ->orWhere('facilities', 'like', "%{$search}%");
            });
        }

        if ($building) {
            $query->where('building', 'like', "%{$building}%");
        }

        if ($capacity) {
            $query->where('capacity', '>=', (int) $capacity);
        }

        $rooms = $query->orderBy('status', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(9)
            ->withQueryString();

        // Ambil semua peminjaman disetujui (Approved) pada tanggal yang dicek untuk ruangan-ruangan ini
        $roomIds = $rooms->pluck('id')->toArray();
        $approvedReservations = Reservation::with('user')
            ->whereIn('room_id', $roomIds)
            ->whereDate('reservation_date', $checkDate)
            ->where('status', 'approved')
            ->get();

        // Hitung status ketersediaan setiap ruangan secara dinamis (Real-time Availability Calculation)
        foreach ($rooms as $room) {
            // Ambil semua jadwal disetujui untuk ruangan ini pada tanggal tersebut
            $roomSchedulesToday = $approvedReservations->where('room_id', $room->id);
            $room->today_schedules = $roomSchedulesToday;

            if ($room->status === 'maintenance') {
                $room->availability_status = 'maintenance';
                $room->availability_label = 'Pemeliharaan (Maintenance)';
                $room->availability_badge = 'bg-secondary text-white';
                $room->active_reservation = null;
            } else {
                // Cek apakah ada jadwal yang beririsan dengan check_start_time dan check_end_time
                // Irisan waktu: start_time < checkEndTime AND end_time > checkStartTime
                $overlapping = $roomSchedulesToday->first(function ($res) use ($checkStartTime, $checkEndTime) {
                    $resStart = substr($res->start_time, 0, 5);
                    $resEnd = substr($res->end_time, 0, 5);
                    return ($resStart < $checkEndTime) && ($resEnd > $checkStartTime);
                });

                if ($overlapping) {
                    $room->availability_status = 'occupied';
                    $room->availability_label = 'Terisi (Occupied)';
                    $room->availability_badge = 'bg-danger text-white';
                    $room->active_reservation = $overlapping;
                } else {
                    $room->availability_status = 'available';
                    $room->availability_label = 'Kosong / Tersedia (Available)';
                    $room->availability_badge = 'bg-success text-white';
                    $room->active_reservation = null;
                }
            }
        }

        // Ambil daftar gedung unik untuk dropdown filter
        $buildings = Room::select('building')->distinct()->pluck('building');

        // Statistik ketersediaan pada slot yang dicek
        $stats = [
            'total' => $rooms->total(),
            'available_count' => $rooms->filter(fn($r) => $r->availability_status === 'available')->count(),
            'occupied_count' => $rooms->filter(fn($r) => $r->availability_status === 'occupied')->count(),
            'maintenance_count' => $rooms->filter(fn($r) => $r->availability_status === 'maintenance')->count(),
        ];

        return view('user.catalog', compact(
            'rooms', 
            'buildings', 
            'search', 
            'building', 
            'capacity', 
            'checkDate', 
            'checkStartTime', 
            'checkEndTime', 
            'preset',
            'stats'
        ));
    }

    /**
     * Detail ruangan beserta jadwal terpakai lengkap
     */
    public function show(Room $room)
    {
        $today = Carbon::today()->toDateString();

        // Jadwal peminjaman disetujui mulai hari ini ke depan (14 hari ke depan)
        $upcomingSchedules = Reservation::with('user')
            ->where('room_id', $room->id)
            ->where('status', 'approved')
            ->whereDate('reservation_date', '>=', $today)
            ->whereDate('reservation_date', '<=', Carbon::today()->addDays(14)->toDateString())
            ->orderBy('reservation_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        // Cek status saat ini
        $now = Carbon::now('Asia/Jakarta');
        $currentTime = $now->format('H:i');
        
        $currentActiveBooking = $upcomingSchedules->first(function ($res) use ($today, $currentTime) {
            return $res->reservation_date->toDateString() === $today 
                && substr($res->start_time, 0, 5) <= $currentTime 
                && substr($res->end_time, 0, 5) >= $currentTime;
        });

        return view('user.rooms.show', compact('room', 'upcomingSchedules', 'currentActiveBooking'));
    }
}
