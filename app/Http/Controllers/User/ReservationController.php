<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    /**
     * Tampilkan riwayat peminjaman user saat ini
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $reservations = Reservation::with(['room', 'approver'])
            ->where('user_id', Auth::id())
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest('created_at')
            ->paginate(8)
            ->withQueryString();

        return view('user.reservations.index', compact('reservations', 'status'));
    }

    /**
     * Tampilkan formulir pengajuan peminjaman ruangan
     */
    public function create(Request $request)
    {
        $selectedRoomId = $request->query('room_id');
        $selectedRoom = $selectedRoomId ? Room::find($selectedRoomId) : null;
        $rooms = Room::where('status', 'available')->orderBy('name')->get();

        return view('user.reservations.create', compact('rooms', 'selectedRoom'));
    }

    /**
     * Proses penyimpanan pengajuan peminjaman dengan validasi anti-bentrok
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'reservation_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'purpose' => ['required', 'string', 'min:10', 'max:1000'],
            'proposal_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ], [
            'room_id.required' => 'Pilih ruangan yang ingin dipinjam.',
            'room_id.exists' => 'Ruangan yang dipilih tidak ditemukan.',
            'reservation_date.required' => 'Tanggal peminjaman wajib diisi.',
            'reservation_date.after_or_equal' => 'Tanggal peminjaman tidak boleh tanggal yang sudah lewat.',
            'start_time.required' => 'Jam mulai wajib diisi.',
            'start_time.date_format' => 'Format jam mulai tidak valid (HH:MM).',
            'end_time.required' => 'Jam selesai wajib diisi.',
            'end_time.date_format' => 'Format jam selesai tidak valid (HH:MM).',
            'end_time.after' => 'Jam selesai harus lebih akhir dari jam mulai.',
            'purpose.required' => 'Keperluan peminjaman wajib dijelaskan secara rinci.',
            'purpose.min' => 'Keperluan peminjaman minimal 10 karakter.',
            'proposal_file.mimes' => 'File lampiran harus berformat PDF, JPG, JPEG, atau PNG.',
            'proposal_file.max' => 'Ukuran berkas maksimal 5MB.',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        // 1. Cek status ketersediaan ruangan
        if ($room->status !== 'available') {
            throw ValidationException::withMessages([
                'room_id' => "Ruangan {$room->name} sedang dalam status Pemeliharaan (Maintenance) dan belum dapat dipinjam.",
            ]);
        }

        // 2. VALIDASI ANTI-BENTROK JADWAL (Overlapping Schedule Check)
        // Mengecek apakah sudah ada peminjaman yang disetujui pada ruangan & tanggal yang sama dengan jam beririsan
        $overlapBooking = Reservation::where('room_id', $validated['room_id'])
            ->whereDate('reservation_date', $validated['reservation_date'])
            ->where('status', 'approved')
            ->where(function ($query) use ($validated) {
                // Logika irisan rentang waktu: (StartA < EndB) AND (EndA > StartB)
                $query->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
            })
            ->first();

        if ($overlapBooking) {
            $formattedOverlapTime = substr($overlapBooking->start_time, 0, 5) . ' - ' . substr($overlapBooking->end_time, 0, 5);
            throw ValidationException::withMessages([
                'start_time' => "JADWAL BENTROK: Ruangan {$room->name} telah disetujui untuk kegiatan lain pada tanggal " . 
                    Carbon::parse($validated['reservation_date'])->translatedFormat('d F Y') . 
                    " pukul {$formattedOverlapTime} WIB. Silakan pilih rentang waktu atau ruangan lain.",
            ]);
        }

        // 3. Upload berkas proposal / surat permohonan jika ada
        $filePath = null;
        if ($request->hasFile('proposal_file')) {
            $filePath = $request->file('proposal_file')->store('proposals', 'public');
        }

        // 4. Simpan peminjaman baru
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'room_id' => $validated['room_id'],
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'purpose' => $validated['purpose'],
            'proposal_file' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->route('peminjam.reservations.index')
            ->with('success', "Permohonan peminjaman untuk {$room->name} berhasil dikirim! Menunggu persetujuan Bagian Sarpras.");
    }

    /**
     * Batalkan peminjaman (hanya jika status masih pending)
     */
    public function cancel(Reservation $reservation)
    {
        // Pastikan milik peminjam yang sedang login
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak untuk membatalkan peminjaman ini.');
        }

        if ($reservation->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya peminjaman berstatus "Pending" yang dapat dibatalkan secara mandiri.');
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->back()
            ->with('info', "Peminjaman ruangan {$reservation->room->name} berhasil dibatalkan.");
    }
}
