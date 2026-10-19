# CampusRoom 🏛️
### Sistem Informasi Peminjaman Ruangan & Fasilitas Kampus
Dibuat dengan **Laravel 11/12** & **Bootstrap 5.3 (Mobile-First Responsive)**

---

## 🌟 Fitur Utama

1. **Autentikasi Manual (Tanpa Starter Kit):**
   - Menggunakan `Auth::attempt()`, registrasi mahasiswa dengan verifikasi data kampus (NIM, No. WhatsApp, Prodi).
   - Custom Middleware `CheckRole` memisahkan hak akses `admin` (Sarpras) dan `mahasiswa` (Peminjam).

2. **Validasi Anti-Bentrok Jadwal (Anti Overlapping Schedule):**
   - Peminjaman divalidasi pada tanggal yang sama dengan rentang waktu yang beririsan:
     `start_time < existing_end_time AND end_time > existing_start_time`.
   - Mencegah double-booking pada ruangan dan jam yang sama.

3. **Role Admin (Bagian Sarpras Kampus):**
   - **Dashboard Ringkas:** KPI Total Ruangan, Peminjaman Pending, Peminjaman Disetujui, dan Jadwal Hari Ini.
   - **CRUD Manajemen Ruangan:** Input spesifikasi ruangan, kapasitas, fasilitas, foto, serta toggle status (Tersedia / Maintenance).
   - **Approval Pengajuan:** Tombol "Setujui" & "Tolak" (disertai modal catatan penolakan).
   - **Tombol WhatsApp Otomatis:** Tombol interaktif langsung membuka WhatsApp (`https://wa.me/{nomor_hp}?text={template_otomatis}`) dengan template notifikasi formal yang sudah terformat rapi.
   - **Rekap & Cetak Laporan:** Filter tanggal, ruangan, status, serta halaman cetak/export PDF dengan kop surat resmi.

4. **Role Mahasiswa / Dosen (Peminjam):**
   - **Katalog Ruangan Interaktif:** Grid kartu responsif dengan foto, fasilitas badges, kapasitas, filter gedung, dan tombol pinjam.
   - **Cek Jadwal Terpakai:** Halaman detail ruangan yang menampilkan agenda ruangan 7 hari ke depan.
   - **Form Pengajuan Peminjaman:** Pilihan ruangan, tanggal, jam mulai & selesai, keperluan acara, dan upload surat/proposal (.pdf/.jpg/.png).
   - **Tracking Peminjaman:** Riwayat pengajuan dengan badge status realtime dan tombol batalkan peminjaman (jika masih status pending).

5. **Desain UI/UX & Responsivitas:**
   - **Mobile First:** Sidebar desktop elegan yang otomatis bertransformasi menjadi Offcanvas Drawer / Hamburger Menu di smartphone/layar sentuh.
   - **Tabel & Card Adaptif:** Menggunakan Bootstrap 5 `table-responsive` dan card-based layout yang nyaman digunakan di layar kecil tanpa merusak layout.

---

## 🚀 Akun Demo & Kredensial

| Role | Email | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Admin Sarpras** | `admin@campusroom.ac.id` | `password` | Pengelola Sarpras, Approval, CRUD Ruangan, Rekap Laporan |
| **Mahasiswa 1** | `mahasiswa@campusroom.ac.id` | `password` | Muhammad Bintang Pratama (BEM Fasilkom) |
| **Mahasiswa 2** | `siti.aisyah@campusroom.ac.id` | `password` | Siti Aisyah Putri (Himpunan Mahasiswa) |

*Tersedia tombol autofill 1-klik di halaman Login untuk mempercepat testing.*

---

## 💻 Cara Menjalankan Proyek

1. **Jalankan Migration & Seed:**
   ```bash
   php artisan migrate:fresh --seed
   ```

2. **Buat Symlink Storage untuk Upload Foto & Proposal:**
   ```bash
   php artisan storage:link
   ```

3. **Jalankan Development Server:**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser di `http://127.0.0.1:8000`.
