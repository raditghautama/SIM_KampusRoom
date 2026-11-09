<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna (Users Management)
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $userType = $request->query('user_type');
        $role = $request->query('role');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('identity_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        if ($userType) {
            $query->where('user_type', $userType);
        }

        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->withCount('reservations')
            ->orderBy('role', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'mahasiswa' => User::where('user_type', 'mahasiswa')->count(),
            'dosen' => User::where('user_type', 'dosen')->count(),
        ];

        return view('admin.users.index', compact('users', 'search', 'userType', 'role', 'stats'));
    }

    /**
     * Tampilkan form tambah pengguna baru
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan pengguna baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'identity_number' => ['required', 'string', 'max:50', 'unique:users,identity_number'],
            'user_type' => ['required', Rule::in(['mahasiswa', 'dosen', 'tendik', 'admin'])],
            'no_hp' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'department' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'identity_number.required' => 'NIM / NIDN / Username wajib diisi.',
            'identity_number.unique' => 'NIM / NIDN / Username sudah terdaftar di sistem.',
            'user_type.required' => 'Pilih kategori pengguna (Mahasiswa / Dosen / Admin).',
            'no_hp.required' => 'Nomor WhatsApp / HP aktif wajib diisi.',
            'department.required' => 'Program Studi / Fakultas / Unit kerja wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // Tetapkan role berdasarkan user_type
        $role = ($validated['user_type'] === 'admin') ? 'admin' : 'peminjam';

        User::create([
            'name' => $validated['name'],
            'identity_number' => $validated['identity_number'],
            'role' => $role,
            'user_type' => $validated['user_type'],
            'no_hp' => $validated['no_hp'],
            'email' => $validated['email'],
            'department' => $validated['department'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna baru '{$validated['name']}' ({$validated['identity_number']}) berhasil ditambahkan.");
    }

    /**
     * Tampilkan form edit pengguna
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Perbarui data pengguna
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'identity_number' => ['required', 'string', 'max:50', Rule::unique('users', 'identity_number')->ignore($user->id)],
            'user_type' => ['required', Rule::in(['mahasiswa', 'dosen', 'tendik', 'admin'])],
            'no_hp' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'department' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'identity_number.required' => 'NIM / NIDN / Username wajib diisi.',
            'identity_number.unique' => 'NIM / NIDN / Username sudah digunakan oleh pengguna lain.',
            'user_type.required' => 'Pilih kategori pengguna.',
            'no_hp.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'department.required' => 'Program Studi / Fakultas wajib diisi.',
            'password.min' => 'Password baru minimal 6 karakter jika ingin diubah.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // Tentukan role berdasarkan user_type
        $role = ($validated['user_type'] === 'admin') ? 'admin' : 'peminjam';

        $updateData = [
            'name' => $validated['name'],
            'identity_number' => $validated['identity_number'],
            'role' => $role,
            'user_type' => $validated['user_type'],
            'no_hp' => $validated['no_hp'],
            'email' => $validated['email'],
            'department' => $validated['department'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', "Data pengguna '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Hapus pengguna dari sistem
     */
    public function destroy(User $user)
    {
        // Proteksi: tidak boleh menghapus akun sendiri yang sedang login
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        // Cek jika user memiliki data peminjaman
        $reservationsCount = $user->reservations()->count();
        $userName = $user->name;

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna '{$userName}' beserta riwayat peminjamannya berhasil dihapus.");
    }
}
