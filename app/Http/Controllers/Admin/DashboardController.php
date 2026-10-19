<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        $stats = [
            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'approved_reservations' => Reservation::where('status', 'approved')->count(),
            'today_reservations' => Reservation::whereDate('reservation_date', $today)->count(),
        ];

        // 5 Peminjaman terbaru
        $recentReservations = Reservation::with(['user', 'room'])
            ->latest()
            ->take(6)
            ->get();

        // Peminjaman disetujui untuk hari ini
        $todaySchedules = Reservation::with(['user', 'room'])
            ->whereDate('reservation_date', $today)
            ->where('status', 'approved')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReservations', 'todaySchedules'));
    }
}
