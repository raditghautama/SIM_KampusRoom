<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Halaman filter & ringkasan laporan peminjaman
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

        $reservations = $query->orderBy('reservation_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

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
     * Export Laporan Resmi Peminjaman ke format PDF (Download)
     */
    public function exportPdf(Request $request)
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

        $reservations = $query->orderBy('reservation_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        $selectedRoom = $roomId ? Room::find($roomId) : null;
        $printDate = Carbon::now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('admin.reports.pdf', compact('reservations', 'startDate', 'endDate', 'selectedRoom', 'status', 'printDate'))
            ->setPaper('a4', 'landscape');

        $filename = 'Laporan-Peminjaman-Ruangan-' . Carbon::parse($startDate)->format('Ymd') . '-sd-' . Carbon::parse($endDate)->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Halaman cetak laporan (Print-Friendly Browser View)
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

        $reservations = $query->orderBy('reservation_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        $selectedRoom = $roomId ? Room::find($roomId) : null;
        $printDate = Carbon::now()->translatedFormat('d F Y');

        return view('admin.reports.print', compact('reservations', 'startDate', 'endDate', 'selectedRoom', 'status', 'printDate'));
    }
}
