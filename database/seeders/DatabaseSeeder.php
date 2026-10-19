<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Sarpras Sesuai Spesifikasi (ADM001 / password / role: admin / no_hp: 081234567890)
        $admin = User::updateOrCreate(
            ['identity_number' => 'ADM001'],
            [
                'name' => 'Administrator Sarpras',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'no_hp' => '081234567890',
                'email' => 'admin@campusroom.ac.id',
                'department' => 'Biro Sarana dan Prasarana Kampus',
            ]
        );

        // 2. Akun Peminjam Sesuai Spesifikasi (2421400096 / password / role: peminjam / no_hp: 081222400511)
        $student1 = User::updateOrCreate(
            ['identity_number' => '2421400096'],
            [
                'name' => 'Muhammad Bintang Pratama',
                'password' => Hash::make('password'),
                'role' => 'peminjam',
                'no_hp' => '081222400511',
                'email' => '2421400096@campusroom.ac.id',
                'department' => 'S1 Informatika - BEM Fasilkom',
            ]
        );

        $student2 = User::updateOrCreate(
            ['identity_number' => '2421400097'],
            [
                'name' => 'Siti Aisyah Putri',
                'password' => Hash::make('password'),
                'role' => 'peminjam',
                'no_hp' => '085712345678',
                'email' => 'siti.aisyah@campusroom.ac.id',
                'department' => 'S1 Sistem Informasi - Himpunan Mahasiswa',
            ]
        );

        // 3. Data Master Ruangan Kampus
        $rooms = [
            [
                'name' => 'Auditorium Utama Prof. Soedarto',
                'code' => 'AUD-01',
                'capacity' => 300,
                'building' => 'Gedung Rektorat Lt. 3',
                'facilities' => 'Sound System Line Array, 2 Proyektor Laser 8000 Lumens, AC Central, Panggung Utama, 4 Mic Wireless, Kursi Teater, Ruang Transit VIP',
                'description' => 'Auditorium berstandar nasional yang sangat cocok untuk seminar internasional, kuliah umum, wisuda, atau pentas seni kampus.',
                'image' => null,
                'status' => 'available',
            ],
            [
                'name' => 'Ruang Seminar Smart Class A',
                'code' => 'SEM-A1',
                'capacity' => 60,
                'building' => 'Gedung Kuliah Bersama (GKB) Lt. 2',
                'facilities' => 'Interactive Smart Board 85", AC 2x 2PK, Audio Speaker Ceiling, High Speed WiFi 6, Kursi Ergonomis Beroda, Glass Whiteboard',
                'description' => 'Ruang kelas pintar berkonsep modern untuk workshop, pelatihan, presentasi ilmiah, atau sidang akhir terbuka.',
                'image' => null,
                'status' => 'available',
            ],
            [
                'name' => 'Laboratorium Komputer & AI',
                'code' => 'LAB-AI',
                'capacity' => 45,
                'building' => 'Gedung Fakultas Ilmu Komputer Lt. 1',
                'facilities' => '45 Unit PC Core i7 GPU RTX 4060, Proyektor Full HD, AC 3x 2PK, Jaringan LAN Gigabit, UPS Central, Meja Lab Standar',
                'description' => 'Lab mutakhir yang siap digunakan untuk sertifikasi IT, hackathon, workshop machine learning, dan praktikum intensif.',
                'image' => null,
                'status' => 'available',
            ],
            [
                'name' => 'Ruang Rapat Senat & Eksekutif',
                'code' => 'RPT-SENAT',
                'capacity' => 30,
                'building' => 'Gedung Rektorat Lt. 2',
                'facilities' => 'Meja Rapat Bundar Kayu Jati, Mic Konferensi Delegasi, TV OLED 75", Video Conference Camera 4K (Zoom Room), AC Central, Dispenser',
                'description' => 'Ruangan representatif untuk rapat pimpinan, audiensi ormawa dengan dekanat, atau musyawarah penting.',
                'image' => null,
                'status' => 'available',
            ],
            [
                'name' => 'Amphitheater Terbuka Plaza Kreatif',
                'code' => 'AMP-PLAZA',
                'capacity' => 150,
                'building' => 'Plaza Barat Pusat Kegiatan Mahasiswa (PKM)',
                'facilities' => 'Panggung Terbuka Beton Bertingkat, Titik Daya Listrik 3 Phase, Lampu Sorot LED Outdoor, Area Terbuka Hijau',
                'description' => 'Panggung terbuka untuk pertunjukan musik akustik, gathering ormawa, nobar, atau pameran karya seni mahasiswa.',
                'image' => null,
                'status' => 'available',
            ],
            [
                'name' => 'Studio Musik & Rekaman UKM Seni',
                'code' => 'STD-SENI',
                'capacity' => 15,
                'building' => 'Gedung PKM Lt. Dasar',
                'facilities' => 'Peredam Suara Akustik, Drum Set Pearl, Ampli Gitar Marshall, Audio Mixer 16 Channel, 2 AC Split',
                'description' => 'Ruangan khusus gladi resik band, rekaman podcast ormawa, dan latihan paduan suara.',
                'image' => null,
                'status' => 'maintenance',
            ],
        ];

        $createdRooms = [];
        foreach ($rooms as $r) {
            $createdRooms[] = Room::firstOrCreate(['code' => $r['code']], $r);
        }

        // 4. Sample Peminjaman (Reservations)
        $today = Carbon::today();
        
        // Peminjaman 1: Disetujui (Hari ini)
        Reservation::firstOrCreate(
            [
                'room_id' => $createdRooms[1]->id,
                'reservation_date' => $today->toDateString(),
                'start_time' => '09:00:00',
            ],
            [
                'user_id' => $student1->id,
                'end_time' => '12:00:00',
                'purpose' => 'Workshop UI/UX Design & Prototyping bersama Praktisi Industri (BEM Fasilkom)',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'admin_notes' => 'Disetujui. Harap memastikan kebersihan ruangan setelah acara selesai.',
            ]
        );

        // Peminjaman 2: Pending (Besok)
        Reservation::firstOrCreate(
            [
                'room_id' => $createdRooms[0]->id,
                'reservation_date' => $today->copy()->addDays(2)->toDateString(),
                'start_time' => '08:00:00',
            ],
            [
                'user_id' => $student1->id,
                'end_time' => '15:00:00',
                'purpose' => 'Seminar Nasional Digital Transformation 2026 dan Pelantikan Pengurus Ormawa',
                'status' => 'pending',
                'admin_notes' => null,
            ]
        );

        // Peminjaman 3: Disetujui (3 hari lagi)
        Reservation::firstOrCreate(
            [
                'room_id' => $createdRooms[2]->id,
                'reservation_date' => $today->copy()->addDays(3)->toDateString(),
                'start_time' => '13:00:00',
            ],
            [
                'user_id' => $student2->id,
                'end_time' => '17:00:00',
                'purpose' => 'Pelatihan Coding Web Development & API Integration untuk Anggota Baru Himpunan',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'admin_notes' => 'Disetujui. Kunci lab dapat diambil di ruang Sarpras H-1 jam kegiatan.',
            ]
        );

        // Peminjaman 4: Ditolak
        Reservation::firstOrCreate(
            [
                'room_id' => $createdRooms[3]->id,
                'reservation_date' => $today->copy()->addDays(4)->toDateString(),
                'start_time' => '10:00:00',
            ],
            [
                'user_id' => $student2->id,
                'end_time' => '12:00:00',
                'purpose' => 'Rapat Internal Panitia Dies Natalis Jurusan',
                'status' => 'rejected',
                'approved_by' => $admin->id,
                'admin_notes' => 'Ruangan Rapat Senat hanya diperuntukkan bagi agenda pimpinan universitas dan dekanat.',
            ]
        );
    }
}
