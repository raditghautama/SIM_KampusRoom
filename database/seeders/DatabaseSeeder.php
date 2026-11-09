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
     * Seed the application's database with required credentials and demo data.
     */
    public function run(): void
    {
        // 1. Akun Admin Sarpras Wajib Sesuai Spesifikasi:
        // Username/NIM-NIDN: admin01 | Password: admin123
        $admin = User::updateOrCreate(
            ['identity_number' => 'admin01'],
            [
                'name' => 'Administrator Sarpras Kampus',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'user_type' => 'admin',
                'no_hp' => '6281234567890',
                'email' => 'admin01@campusroom.ac.id',
                'department' => 'Biro Sarana dan Prasarana Kampus',
            ]
        );

        // 2. Akun Peminjam Wajib Sesuai Spesifikasi:
        // Nama: Radit Ghautama | Username/NIM: 2421400096 | No. WA: 6281222400511 | Password: Hash::make('Meedha85')
        $radit = User::updateOrCreate(
            ['identity_number' => '2421400096'],
            [
                'name' => 'Radit Ghautama',
                'password' => Hash::make('Meedha85'),
                'role' => 'peminjam',
                'user_type' => 'mahasiswa',
                'no_hp' => '6281222400511',
                'email' => 'raditghautama@campusroom.ac.id',
                'department' => 'S1 Teknik Informatika - BEM Fakultas',
            ]
        );

        // 3. Akun Peminjam Dosen (Akun Tambahan untuk Uji Coba Multi-Role Mahasiswa & Dosen)
        $dosen = User::updateOrCreate(
            ['identity_number' => '198705122015041001'],
            [
                'name' => 'Dr. Ir. Hendra Saputra, M.T.',
                'password' => Hash::make('PasswordAdmin123'),
                'role' => 'peminjam',
                'user_type' => 'dosen',
                'no_hp' => '6281298765432',
                'email' => 'hendra.saputra@campusroom.ac.id',
                'department' => 'Dosen Teknik Komputer & Jaringan',
            ]
        );

        $student2 = User::updateOrCreate(
            ['identity_number' => '2421400097'],
            [
                'name' => 'Siti Aisyah Putri',
                'password' => Hash::make('Meedha85'),
                'role' => 'peminjam',
                'user_type' => 'mahasiswa',
                'no_hp' => '6285712345678',
                'email' => 'siti.aisyah@campusroom.ac.id',
                'department' => 'S1 Sistem Informasi - Himpunan Mahasiswa',
            ]
        );

        // 4. Data Master Ruangan Kampus
        $rooms = [
            [
                'name' => 'Aula Fakultas Teknik',
                'code' => 'AUD-01',
                'capacity' => 350,
                'building' => 'Gedung D lt.3',
                'facilities' => 'Sound System Line Array, 2 Proyektor Laser 8000 Lumens, AC Central, Panggung Utama, 4 Mic Wireless, Kursi Teater, Ruang Transit VIP',
                'description' => 'aula berstandar nasional yang sangat cocok untuk seminar internasional, kuliah umum, wisuda, atau pentas seni kampus.',
                'image' => null,
                'status' => 'available',
            ],
            [
                'name' => 'Aula Fakultas Kesehatan',
                'code' => 'SEM-A1',
                'capacity' => 60,
                'building' => 'Gedung A3',
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
                'name' => 'Lab.Komputasi Cerdas',
                'code' => 'AMP-LABKOMCE',
                'capacity' => 150,
                'building' => 'Plaza Barat Pusat Kegiatan Mahasiswa (PKM)',
                'facilities' => 'Komputer, Proyektor, AC',
                'description' => 'Laboratorium Komputasi Cerdas.',
                'image' => null,
                'status' => 'available',
            ],
            [
                'name' => 'Studio Multimedia & Podcast',
                'code' => 'STD-MEDIA',
                'capacity' => 15,
                'building' => 'Gedung PKM Lt. Dasar',
                'facilities' => 'Acoustic Soundproofing, 4 Mic Rode PodMic, Audio Interface Rodecaster Pro II, 3 Kamera Sony 4K, Lighting Ring Light Softbox',
                'description' => 'Ruangan khusus produksi konten digital, rekaman podcast kampus, webinar ormawa, dan siaran pers universitas.',
                'image' => null,
                'status' => 'available',
            ],
            [
                'name' => 'Ruang Teater Seni & Musik UKM',
                'code' => 'TTR-MUSIK',
                'capacity' => 40,
                'building' => 'Gedung Pusat Budaya Mahasiswa Lt. 2',
                'facilities' => 'Peredam Suara Akustik, Drum Set Pearl, Ampli Gitar Marshall, Audio Mixer 16 Channel, 2 AC Split',
                'description' => 'Ruangan khusus gladi resik band, latihan teater, paduan suara, dan tari tradisional.',
                'image' => null,
                'status' => 'maintenance',
            ],
        ];

        $createdRooms = [];
        foreach ($rooms as $r) {
            $createdRooms[] = Room::updateOrCreate(['code' => $r['code']], $r);
        }

        // 5. Data Sample Peminjaman (Reservations)
        $today = Carbon::today();
        
        // Peminjaman 1: Disetujui (Sedang Berlangsung Hari Ini 08:00 - 18:00 WIB agar langsung berstatus Terisi / Occupied secara real-time)
        Reservation::updateOrCreate(
            [
                'room_id' => $createdRooms[1]->id,
                'reservation_date' => $today->toDateString(),
                'start_time' => '08:00:00',
            ],
            [
                'user_id' => $radit->id,
                'end_time' => '17:00:00',
                'purpose' => 'Workshop UI/UX Design & Full-Stack Application Development bersama Praktisi Industri (BEM Fasilkom)',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'admin_notes' => 'Disetujui. Harap memastikan kebersihan ruangan, AC, dan proyektor dimatikan setelah selesai kegiatan.',
            ]
        );

        // Peminjaman 2: Status PENDING untuk Radit Ghautama (Siap di-approve oleh Admin dan langsung memunculkan tombol WhatsApp)
        Reservation::updateOrCreate(
            [
                'room_id' => $createdRooms[0]->id,
                'reservation_date' => $today->copy()->addDays(2)->toDateString(),
                'start_time' => '08:30:00',
            ],
            [
                'user_id' => $radit->id,
                'end_time' => '15:30:00',
                'purpose' => 'Seminar Nasional Digital Transformation & AI In Education 2026 (Pelantikan Pengurus Baru BEM)',
                'status' => 'pending',
                'admin_notes' => null,
            ]
        );

        // Peminjaman 3: PENDING dari Dosen
        Reservation::updateOrCreate(
            [
                'room_id' => $createdRooms[2]->id,
                'reservation_date' => $today->copy()->addDays(1)->toDateString(),
                'start_time' => '09:00:00',
            ],
            [
                'user_id' => $dosen->id,
                'end_time' => '12:00:00',
                'purpose' => 'Sertifikasi Keahlian Jaringan Komputer & Cloud Computing Mahasiswa Tingkat Akhir',
                'status' => 'pending',
                'admin_notes' => null,
            ]
        );

        // Peminjaman 4: Disetujui (3 hari lagi)
        Reservation::updateOrCreate(
            [
                'room_id' => $createdRooms[3]->id,
                'reservation_date' => $today->copy()->addDays(3)->toDateString(),
                'start_time' => '13:00:00',
            ],
            [
                'user_id' => $dosen->id,
                'end_time' => '16:00:00',
                'purpose' => 'Rapat Koordinasi Hibah Penelitian Dosen & Kerjasama Lembaga Mitra Industri',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'admin_notes' => 'Disetujui. Smart display dan video conference telah disiapkan.',
            ]
        );

        // Peminjaman 5: Ditolak (Sample)
        Reservation::updateOrCreate(
            [
                'room_id' => $createdRooms[4]->id,
                'reservation_date' => $today->copy()->addDays(4)->toDateString(),
                'start_time' => '19:00:00',
            ],
            [
                'user_id' => $student2->id,
                'end_time' => '22:00:00',
                'purpose' => 'Pentas Akustik Musik Malam Ormawa',
                'status' => 'rejected',
                'approved_by' => $admin->id,
                'admin_notes' => 'Mohon maaf, perizinan kegiatan luar ruangan di atas jam 21:00 WIB dilarang oleh tata tertib kampus demi ketenangan asrama/lingkungan sekitar.',
            ]
        );
    }
}
