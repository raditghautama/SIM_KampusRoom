<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\User\RoomCatalogController;
use App\Http\Controllers\User\ReservationController as UserReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes - CampusRoom
|--------------------------------------------------------------------------
*/

// Redirect root ke login atau dashboard/katalog sesuai role jika sudah login
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('peminjam.room-catalog');
    }
    return redirect()->route('login');
});

// Authentication Routes (Manual Auth dengan identity_number & password)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Role Peminjam Routes (/peminjam/room-catalog, /peminjam/dashboard, dll)
Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {
    Route::get('/room-catalog', [RoomCatalogController::class, 'index'])->name('room-catalog');
    Route::get('/dashboard', function () {
        return redirect()->route('peminjam.room-catalog');
    })->name('dashboard');
    Route::get('/room-catalog/{room}', [RoomCatalogController::class, 'show'])->name('rooms.show');
    Route::get('/pinjam-ruangan', [UserReservationController::class, 'create'])->name('reservations.create');
    Route::post('/pinjam-ruangan', [UserReservationController::class, 'store'])->name('reservations.store');
    Route::get('/riwayat-peminjaman', [UserReservationController::class, 'index'])->name('reservations.index');
    Route::post('/riwayat-peminjaman/{reservation}/batal', [UserReservationController::class, 'cancel'])->name('reservations.cancel');
});

// Backward compatibility alias route name 'user.catalog' dsb.
Route::middleware(['auth', 'role:peminjam'])->name('user.')->group(function () {
    Route::get('/katalog', fn() => redirect()->route('peminjam.room-catalog'))->name('catalog');
    Route::get('/user/rooms/{room}', fn($room) => redirect()->route('peminjam.rooms.show', $room))->name('rooms.show');
    Route::get('/user/pinjam', fn() => redirect()->route('peminjam.reservations.create'))->name('reservations.create');
    Route::post('/user/pinjam', [UserReservationController::class, 'store'])->name('reservations.store');
    Route::get('/user/riwayat', fn() => redirect()->route('peminjam.reservations.index'))->name('reservations.index');
    Route::post('/user/riwayat/{reservation}/batal', [UserReservationController::class, 'cancel'])->name('reservations.cancel');
});

// Role Admin (Pengelola Sarpras) Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Manajemen Ruangan
    Route::resource('rooms', AdminRoomController::class);
    
    // Manajemen & Persetujuan Peminjaman
    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations/{reservation}/approve', [AdminReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('/reservations/{reservation}/reject', [AdminReservationController::class, 'reject'])->name('reservations.reject');
    
    // Laporan & Cetak
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [AdminReportController::class, 'print'])->name('reports.print');
});
