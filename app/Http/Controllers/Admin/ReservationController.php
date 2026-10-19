<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Tampilkan daftar seluruh peminjaman
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $date = $request->query('date');
        $search = $request->query('search');

        $reservations = Reservation::with(['user', 'room', 'approver'])
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($date, function ($query, $date) {
                $query->whereDate('reservation_date', $date);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                           ->orWhere('identity_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('room', function ($rq) use ($search) {
                        $rq->where('name', 'like', "%{$search}%")
                           ->orWhere('code', 'like', "%{$search}%");
                    })
                    ->orWhere('purpose', 'like', "%{$search}%");
                });
            })
            ->latest('reservation_date')
            ->latest('start_time')
            ->paginate(12)
            ->withQueryString();

        return view('admin.reservations.index', compact('reservations', 'status', 'date', 'search'));
    }

    /**
     * Setujui peminjaman ruangan
     */
    public function approve(Request $request, Reservation $reservation)
    {
        // Validasi overlap ganda saat admin menyetujui
        $overlap = Reservation::where('room_id', $reservation->room_id)
            ->whereDate('reservation_date', $reservation->reservation_date)
            ->where('status', 'approved')
            ->where('id', '!=', $reservation->id)
            ->where(function ($query) use ($reservation) {
                $query->where('start_time', '<', $reservation->end_time)
                      ->where('end_time', '>', $reservation->start_time);
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->with('error', "Gagal menyetujui! Sudah ada jadwal lain yang DISETUJUI pada tanggal dan jam beririsan untuk ruangan {$reservation->room->name}.");
        }

        $reservation->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'admin_notes' => $request->input('admin_notes', 'Disetujui oleh Bagian Sarana dan Prasarana.'),
        ]);

        $waLink = $reservation->whatsapp_url;

        return redirect()->back()->with([
            'success' => "Peminjaman oleh {$reservation->user->name} untuk ruangan {$reservation->room->name} BERHASIL DISETUJUI.",
            'wa_link' => $waLink,
            'wa_recipient' => $reservation->user->name,
        ]);
    }

    /**
     * Tolak peminjaman ruangan
     */
    public function reject(Request $request, Reservation $reservation)
    {
        $request->validate([
            'admin_notes' => ['required', 'string', 'max:500'],
        ], [
            'admin_notes.required' => 'Harap berikan alasan penolakan peminjaman agar peminjam memahami alasannya.',
        ]);

        $reservation->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'admin_notes' => $request->input('admin_notes'),
        ]);

        $waLink = $reservation->whatsapp_url;

        return redirect()->back()->with([
            'warning' => "Peminjaman oleh {$reservation->user->name} telah DITOLAK.",
            'wa_link' => $waLink,
            'wa_recipient' => $reservation->user->name,
        ]);
    }
}
