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
     * Tampilkan katalog ruangan dengan pencarian & filter
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $building = $request->query('building');
        $capacity = $request->query('capacity');
        $date = $request->query('date', Carbon::today()->toDateString());

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

        // Ambil daftar gedung unik untuk dropdown filter
        $buildings = Room::select('building')->distinct()->pluck('building');

        return view('user.catalog', compact('rooms', 'buildings', 'search', 'building', 'capacity', 'date'));
    }

    /**
     * Detail ruangan beserta jadwal terpakai
     */
    public function show(Room $room)
    {
        $today = Carbon::today()->toDateString();

        // Jadwal peminjaman disetujui mulai hari ini ke depan (7 hari ke depan)
        $upcomingSchedules = Reservation::where('room_id', $room->id)
            ->where('status', 'approved')
            ->whereDate('reservation_date', '>=', $today)
            ->whereDate('reservation_date', '<=', Carbon::today()->addDays(7)->toDateString())
            ->orderBy('reservation_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('user.rooms.show', compact('room', 'upcomingSchedules'));
    }
}
