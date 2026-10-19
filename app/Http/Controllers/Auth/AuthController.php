<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' 
                ? redirect()->route('admin.dashboard')
                : redirect()->route('peminjam.room-catalog');
        }

        return view('auth.login');
    }

    /**
     * Proses login manual menggunakan identity_number dan password
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identity_number' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'identity_number.required' => 'Nomor Identitas (NIDN / NIM / NIP) wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt([
            'identity_number' => $credentials['identity_number'],
            'password' => $credentials['password'],
        ], $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $roleLabel = $user->role === 'admin' ? 'Administrator Sarpras' : 'Peminjam Ruangan';

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', "Selamat datang kembali, {$user->name}! Login berhasil sebagai {$roleLabel}.");
            }

            return redirect()->intended(route('peminjam.room-catalog'))
                ->with('success', "Selamat datang, {$user->name}! Silakan telusuri katalog ruangan yang tersedia.");
        }

        throw ValidationException::withMessages([
            'identity_number' => 'Username (NIDN / NIM / NIP) atau password yang Anda masukkan salah.',
        ]);
    }

    /**
     * Tampilkan form registrasi akun peminjam
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('peminjam.room-catalog');
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi akun peminjam baru
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'identity_number' => ['required', 'string', 'max:50', 'unique:users,identity_number'],
            'no_hp' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'department' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'identity_number.required' => 'NIDN / NIM / NIP wajib diisi.',
            'identity_number.unique' => 'Nomor Identitas tersebut sudah terdaftar.',
            'no_hp.required' => 'Nomor Handphone / WhatsApp aktif wajib diisi.',
            'department.required' => 'Program Studi / Instansi wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'identity_number' => $validated['identity_number'],
            'no_hp' => $validated['no_hp'],
            'email' => $validated['email'] ?? ($validated['identity_number'] . '@campusroom.ac.id'),
            'department' => $validated['department'],
            'role' => 'peminjam',
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('peminjam.room-catalog')
            ->with('success', "Akun Anda berhasil didaftarkan! Selamat datang di CampusRoom, {$user->name}.");
    }

    /**
     * Logout pengguna
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}
