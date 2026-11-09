<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman pengaturan profil dan ganti password
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Perbarui data informasi pribadi pengguna
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'department' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'no_hp.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah digunakan oleh akun lain.',
            'department.required' => 'Program Studi / Fakultas / Unit kerja wajib diisi.',
        ]);

        $user->update($validated);

        return redirect()->route('profile.index')
            ->with('success', 'Informasi profil pribadi Anda berhasil diperbarui!');
    }

    /**
     * Perbarui kata sandi (Password) pengguna dengan verifikasi password lama
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ], [
            'current_password.required' => 'Password saat ini (lama) wajib diisi.',
            'current_password.current_password' => 'Password saat ini yang Anda masukkan tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal harus terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.different' => 'Password baru harus berbeda dari password saat ini.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password Anda berhasil diperbarui! Silakan gunakan password baru ini untuk login berikutnya.');
    }
}
