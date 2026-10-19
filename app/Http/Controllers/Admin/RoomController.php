<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Tampilkan daftar ruangan
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $rooms = Room::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%")
                      ->orWhere('building', 'like', "%{$search}%")
                      ->orWhere('facilities', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->withCount('reservations')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.rooms.index', compact('rooms', 'search', 'status'));
    }

    /**
     * Form tambah ruangan
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Simpan data ruangan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:rooms,code'],
            'capacity' => ['required', 'integer', 'min:1'],
            'building' => ['required', 'string', 'max:255'],
            'facilities' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['available', 'maintenance'])],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ], [
            'name.required' => 'Nama ruangan wajib diisi.',
            'code.required' => 'Kode ruangan wajib diisi.',
            'code.unique' => 'Kode ruangan sudah digunakan.',
            'capacity.required' => 'Kapasitas wajib diisi minimal 1 orang.',
            'building.required' => 'Gedung/Lokasi wajib diisi.',
            'image.max' => 'Ukuran foto maksimal 3MB.',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
            $validated['image'] = $path;
        }

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', "Ruangan '{$validated['name']}' berhasil ditambahkan ke dalam sistem.");
    }

    /**
     * Form edit ruangan
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Perbarui data ruangan
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', Rule::unique('rooms', 'code')->ignore($room->id)],
            'capacity' => ['required', 'integer', 'min:1'],
            'building' => ['required', 'string', 'max:255'],
            'facilities' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['available', 'maintenance'])],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ], [
            'name.required' => 'Nama ruangan wajib diisi.',
            'code.required' => 'Kode ruangan wajib diisi.',
            'code.unique' => 'Kode ruangan sudah digunakan.',
            'capacity.required' => 'Kapasitas wajib diisi.',
            'building.required' => 'Gedung/Lokasi wajib diisi.',
            'image.max' => 'Ukuran foto maksimal 3MB.',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            $path = $request->file('image')->store('rooms', 'public');
            $validated['image'] = $path;
        }

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', "Data ruangan '{$room->name}' berhasil diperbarui.");
    }

    /**
     * Hapus ruangan
     */
    public function destroy(Room $room)
    {
        $roomName = $room->name;

        // Cek jika ada peminjaman aktif
        $activeBookings = $room->reservations()->whereIn('status', ['pending', 'approved'])->count();
        if ($activeBookings > 0) {
            return redirect()->route('admin.rooms.index')
                ->with('error', "Ruangan '{$roomName}' tidak dapat dihapus karena masih memiliki {$activeBookings} peminjaman aktif/pending.");
        }

        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', "Ruangan '{$roomName}' berhasil dihapus dari sistem.");
    }
}
