<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Halaman filter & ringkasan laporan
     */
    public function index(Request $request)
    {
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->endOfMonth()->toDateString());
        $roomId = $request->query('room_id');
        $status = $request->query('status');

        $query = Reservation::with(['user', 'room', 'approver'])
            ->whereBetween('reservation_date', [$startDate, $endDate]);

        if ($roomId) {
            $query->where('room_id', $roomId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $reservations = $query->orderBy('reservation_date', 'asc')->get();

        $rooms = Room::orderBy('name')->get();

        $summary = [
            'total' => $reservations->count(),
            'approved' => $reservations->where('status', 'approved')->count(),
            'pending' => $reservations->where('status', 'pending')->count(),
            'rejected' => $reservations->where('status', 'rejected')->count(),
        ];

        return view('admin.reports.index', compact('reservations', 'rooms', 'startDate', 'endDate', 'roomId', 'status', 'summary'));
    }

    /**
     * Halaman cetak laporan (Print Friendly / PDF-ready View)
     */
    public function print(Request $request)
    {
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->endOfMonth()->toDateString());
        $roomId = $request->query('room_id');
        $status = $request->query('status');

        $query = Reservation::with(['user', 'room', 'approver'])
            ->whereBetween('reservation_date', [$startDate, $endDate]);

        if ($roomId) {
            $query->where('room_id', $roomId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $reservations = $query->orderBy('reservation_date', 'asc')->get();
        $selectedRoom = $roomId ? Room::find($roomId) : null;

        return view('admin.reports.print', compact('reservations', 'startDate', 'endDate', 'selectedRoom', 'status'));
    }
}
