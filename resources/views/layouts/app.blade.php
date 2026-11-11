<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'SIM CampusRoom') - Sistem Informasi Peminjaman Ruangan Kampus</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logounuja.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --cr-primary: #1e40af;
            --cr-primary-light: #2563eb;
            --cr-primary-soft: #eff6ff;
            --cr-dark: #0f172a;
            --cr-sidebar-bg: #0f172a;
            --cr-sidebar-text: #94a3b8;
            --cr-sidebar-active: #38bdf8;
            --cr-bg: #f8fafc;
            --cr-card-border: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--cr-bg);
            color: #1e293b;
            min-height: 100vh;
        }

        /* Sidebar Styling (Desktop) */
        .sidebar-desktop {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .main-wrapper {
            margin-left: 260px;
            transition: all 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        @media (max-width: 991.98px) {
            .sidebar-desktop {
                display: none !important;
            }
            .main-wrapper {
                margin-left: 0 !important;
            }
        }

        /* Brand Header */
        .brand-box {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-title {
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #ffffff;
            font-size: 1.2rem;
        }

        /* Nav links in sidebar */
        .nav-sidebar .nav-link {
            color: #94a3b8;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.72rem 1.15rem;
            border-radius: 0.65rem;
            margin: 0.18rem 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            transition: all 0.2s ease;
        }

        .nav-sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.08);
            transform: translateX(3px);
        }

        .nav-sidebar .nav-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        .nav-sidebar .nav-header {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            font-weight: 700;
            padding: 0.9rem 1.25rem 0.35rem;
        }

        /* Top Navbar */
        .top-navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--cr-card-border);
            padding: 0.85rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* Cards & Components */
        .card-custom {
            border: 1px solid var(--cr-card-border);
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            background: #ffffff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.08);
        }

        /* WhatsApp Button */
        .btn-wa {
            background-color: #25D366;
            color: #ffffff;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
        }
        .btn-wa:hover {
            background-color: #20bd5a;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(37, 211, 102, 0.4);
        }

        /* Floating WA notification banner */
        .wa-floating-alert {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.25);
        }

        /* Realtime Pulsing Status Dots */
        .pulse-dot-green {
            display: inline-block;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background-color: #10b981;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 1.8s infinite cubic-bezier(0.66, 0, 0, 1);
        }
        @keyframes pulse-green {
            to {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }
        }

        .pulse-dot-red {
            display: inline-block;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background-color: #ef4444;
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            animation: pulse-red 1.8s infinite cubic-bezier(0.66, 0, 0, 1);
        }
        @keyframes pulse-red {
            to {
                box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
            }
        }

        /* MOBILE BOTTOM NAVIGATION BAR (FIXED AT BOTTOM) */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid var(--cr-card-border);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
            z-index: 1045;
            padding: 0 0.5rem;
            justify-content: space-around;
            align-items: center;
        }

        .mobile-bottom-nav .nav-item-mobile {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #64748b;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.2s ease;
            position: relative;
            padding: 0.35rem 0;
        }

        .mobile-bottom-nav .nav-item-mobile i {
            font-size: 1.25rem;
            margin-bottom: 2px;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .mobile-bottom-nav .nav-item-mobile.active {
            color: #2563eb;
        }

        .mobile-bottom-nav .nav-item-mobile.active i {
            transform: translateY(-2px);
            color: #2563eb;
        }

        .mobile-bottom-nav .nav-item-mobile.active::after {
            content: '';
            position: absolute;
            bottom: 3px;
            width: 18px;
            height: 3px;
            border-radius: 2px;
            background: #2563eb;
        }

        @media (max-width: 767.98px) {
            .mobile-bottom-nav {
                display: flex !important;
            }
            body {
                padding-bottom: 74px !important;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- SIDEBAR FOR DESKTOP -->
    <aside class="sidebar-desktop d-none d-lg-flex flex-column">
        <div class="brand-box d-flex align-items-center gap-2">
            <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                <i class="fa-solid fa-building-columns"></i>
            </div>
            <div>
                <div class="brand-title">SIKAM</div>
                <small class="text-secondary" style="font-size: 0.72rem;">Sistem Peminjaman Ruangan</small>
            </div>
        </div>

        <div class="flex-grow-1 overflow-y-auto py-3">
            @if(Auth::check() && Auth::user()->role === 'admin')
                <ul class="nav flex-column nav-sidebar">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-chart-pie"></i>
                            <span>Dashboard Utama</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.rooms.index') }}" class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-door-open"></i>
                            <span>Kelola Ruangan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.reservations.index') }}" class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Approval Peminjaman</span>
                            @php
                                $pendingCount = \App\Models\Reservation::where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge bg-warning text-dark rounded-pill ms-auto fw-bold" style="font-size: 0.7rem;">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>

                <ul class="nav flex-column nav-sidebar">
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-users-gear"></i>
                            <span>Manajemen Pengguna</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-invoice"></i>
                            <span>Laporan & Cetak</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-gear"></i>
                            <span>Pengaturan Akun</span>
                        </a>
                    </li>
                </ul>
            @else
                {{-- MENU PEMINJAM --}}
                <ul class="nav flex-column nav-sidebar">
                    <li class="nav-item">
                        <a href="{{ route('peminjam.room-catalog') }}" class="nav-link {{ request()->routeIs('peminjam.room-catalog') || request()->routeIs('peminjam.rooms.show') ? 'active' : '' }}">
                            <i class="fa-solid fa-compass"></i>
                            <span>Katalog & Ketersediaan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peminjam.reservations.create') }}" class="nav-link {{ request()->routeIs('peminjam.reservations.create') ? 'active' : '' }}">
                            <i class="fa-solid fa-circle-plus"></i>
                            <span>Ajukan Peminjaman</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peminjam.reservations.index') }}" class="nav-link {{ request()->routeIs('peminjam.reservations.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <span>Riwayat Peminjaman</span>
                        </a>
                    </li>
                </ul>

                <ul class="nav flex-column nav-sidebar">
                    <li class="nav-item">
                        <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-gear"></i>
                            <span>Profil & Password</span>
                        </a>
                    </li>
                </ul>
            @endif
        </div>

        {{-- Profil User di Footer Sidebar Desktop --}}
        <div class="p-3 border-top border-white border-opacity-10">
            <a href="{{ route('profile.index') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <div class="rounded-circle bg-primary bg-opacity-25 text-primary-light d-flex align-items-center justify-content-center fw-bold text-white" style="width: 38px; height: 38px;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="overflow-hidden flex-grow-1">
                    <div class="text-white text-truncate fw-semibold" style="font-size: 0.88rem;">{{ Auth::user()->name ?? 'Pengguna' }}</div>
                    <span class="badge {{ Auth::user()->role === 'admin' ? 'bg-danger' : 'bg-primary' }} text-white" style="font-size: 0.65rem;">
                        {{ Auth::user()->role === 'admin' ? 'Admin Sarpras' : (Auth::user()->isDosen() ? 'Dosen' : 'Mahasiswa') }}
                    </span>
                </div>
            </a>
        </div>
    </aside>

    <!-- OFFCANVAS DRAWER FOR MOBILE (Opsional / Hamburger) -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="max-width: 280px; background: #0f172a !important;">
        <div class="offcanvas-header border-bottom border-white border-opacity-10 py-3">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <h5 class="offcanvas-title fw-bold text-white fs-6" id="mobileSidebarLabel">SIKAM</h5>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 py-2">
            @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="nav-header px-3">Admin Sarpras</div>
                <ul class="nav flex-column nav-sidebar">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-chart-pie"></i>
                            <span>Dashboard Utama</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.rooms.index') }}" class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-door-open"></i>
                            <span>Kelola Ruangan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.reservations.index') }}" class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Approval Peminjaman</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-users-gear"></i>
                            <span>Manajemen Pengguna</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-invoice"></i>
                            <span>Laporan & Cetak</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-gear"></i>
                            <span>Pengaturan Akun</span>
                        </a>
                    </li>
                </ul>
            @else
                <div class="nav-header px-3">Menu Peminjaman</div>
                <ul class="nav flex-column nav-sidebar">
                    <li class="nav-item">
                        <a href="{{ route('peminjam.room-catalog') }}" class="nav-link {{ request()->routeIs('peminjam.room-catalog') ? 'active' : '' }}">
                            <i class="fa-solid fa-compass"></i>
                            <span>Katalog Ruangan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peminjam.reservations.create') }}" class="nav-link {{ request()->routeIs('peminjam.reservations.create') ? 'active' : '' }}">
                            <i class="fa-solid fa-circle-plus"></i>
                            <span>Ajukan Peminjaman</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peminjam.reservations.index') }}" class="nav-link {{ request()->routeIs('peminjam.reservations.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <span>Riwayat Peminjaman</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-gear"></i>
                            <span>Profil & Password</span>
                        </a>
                    </li>
                </ul>
            @endif

            <hr class="border-white border-opacity-10 my-3">
            <div class="px-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 rounded-3 py-2 text-start d-flex align-items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar (Logout)</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="main-wrapper">
        <!-- TOP NAVBAR -->
        <header class="top-navbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <!-- Hamburger Button for Mobile -->
                <button class="btn btn-light border d-lg-none rounded-3 px-3 py-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                    <i class="fa-solid fa-bars text-secondary"></i>
                </button>
                
                <div>
                    <h5 class="mb-0 fw-bold d-none d-sm-block text-dark">@yield('page_heading', 'SIKAM')</h5>
                    <small class="text-muted d-none d-md-block">Sistem Informasi Peminjaman Sarpras & Fasilitas Kampus</small>
                </div>
            </div>

            <!-- Profile & Quick Action Right -->
            <div class="d-flex align-items-center gap-2 gap-sm-3">
                @if(Auth::check() && Auth::user()->role === 'peminjam')
                    <a href="{{ route('peminjam.reservations.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-2 d-none d-sm-inline-flex align-items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-plus"></i>
                        <span>Pinjam Ruangan</span>
                    </a>
                @endif

                <div class="dropdown">
                    <button class="btn btn-light border rounded-pill d-flex align-items-center gap-2 py-1 px-2 pe-3 dropdown-toggle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="text-start d-none d-sm-block">
                            <div class="fw-semibold lh-1" style="font-size: 0.85rem;">{{ Auth::user()->name ?? 'Pengguna' }}</div>
                            <small class="text-muted" style="font-size: 0.7rem;">{{ ucfirst(Auth::user()->role ?? '') }} ({{ Auth::user()->identity_number }})</small>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2 p-2" style="min-width: 220px;">
                        <li class="px-3 py-2 border-bottom">
                            <span class="text-muted d-block small">Akun Masuk:</span>
                            <span class="fw-bold small text-truncate d-block">{{ Auth::user()->name }}</span>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle mt-1" style="font-size: 0.7rem;">
                                {{ Auth::user()->identity_number }}
                            </span>
                        </li>
                        <li>
                            <a href="{{ route('profile.index') }}" class="dropdown-item rounded-3 py-2 d-flex align-items-center gap-2 mt-1">
                                <i class="fa-solid fa-user-gear text-secondary"></i>
                                <span>Pengaturan Akun</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger rounded-3 py-2 d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- FLASH NOTIFICATIONS -->
        <div class="container-fluid px-3 px-md-4 pt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center gap-3 p-3" role="alert">
                    <div class="bg-success text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Berhasil!</div>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center gap-3 p-3" role="alert">
                    <div class="bg-danger text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Terjadi Kesalahan!</div>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center gap-3 p-3" role="alert">
                    <div class="bg-info text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fa-solid fa-info"></i>
                    </div>
                    <div>
                        <div>{{ session('info') }}</div>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('wa_link'))
                <div class="card wa-floating-alert border-0 p-3 p-md-4 mb-3">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; font-size: 1.5rem;">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Persetujuan Berhasil & WhatsApp Siap Dikirim!</h6>
                                <p class="mb-0 text-white-50 small">
                                    Peminjaman berhasil disetujui. Kirim notifikasi WhatsApp resmi kepada <strong>{{ session('wa_recipient') }}</strong> dengan template pesan otomatis.
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ session('wa_link') }}" target="_blank" class="btn btn-light fw-bold text-success rounded-pill px-4 py-2 shadow-sm d-inline-flex align-items-center gap-2">
                                <i class="fab fa-whatsapp fa-lg"></i>
                                <span>Kirim WhatsApp Sekarang</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- MAIN DYNAMIC CONTENT -->
        <main class="flex-grow-1 px-3 px-md-4 pb-4">
            @yield('content')
        </main>

        <!-- FOOTER (DESKTOP) -->
        <footer class="py-3 px-4 border-top bg-white text-center text-muted small mt-auto">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <span>&copy; {{ date('Y') }} <strong>SIKAM</strong> &bull; Sistem Informasi KampusRoom.</span>
                <span class="badge bg-light text-secondary border">SIKAM</span>
            </div>
        </footer>
    </div>

    <!-- MOBILE BOTTOM NAVIGATION BAR (KHUSUS SMARTPHONE / MOBILE-FIRST NAVIGATION) -->
    <nav class="mobile-bottom-nav">
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="nav-item-mobile {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="nav-item-mobile {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                <i class="fa-solid fa-door-open"></i>
                <span>Ruangan</span>
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="nav-item-mobile {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Approval</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-item-mobile {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i>
                <span>Users</span>
            </a>
            <a href="{{ route('profile.index') }}" class="nav-item-mobile {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i>
                <span>Profil</span>
            </a>
        @else
            <a href="{{ route('peminjam.room-catalog') }}" class="nav-item-mobile {{ request()->routeIs('peminjam.room-catalog') || request()->routeIs('peminjam.rooms.show') ? 'active' : '' }}">
                <i class="fa-solid fa-compass"></i>
                <span>Ruangan</span>
            </a>
            <a href="{{ route('peminjam.reservations.create') }}" class="nav-item-mobile {{ request()->routeIs('peminjam.reservations.create') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Pinjam</span>
            </a>
            <a href="{{ route('peminjam.reservations.index') }}" class="nav-item-mobile {{ request()->routeIs('peminjam.reservations.index') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Riwayat</span>
            </a>
            <a href="{{ route('profile.index') }}" class="nav-item-mobile {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i>
                <span>Profil</span>
            </a>
        @endif
    </nav>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
