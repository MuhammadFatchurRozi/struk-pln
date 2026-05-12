<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Struk PLN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* Menggunakan font Plus Jakarta Sans agar terlihat lebih modern */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        :root {
            --primary-color: #0d6efd;
            --navbar-height: 70px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            /* Warna abu-abu yang lebih soft */
            color: #1e293b;
        }

        /* Navbar Modern dengan Efek Glassmorphism */
        .navbar {
            height: var(--navbar-height);
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(10px);
            /* Efek blur kaca */
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #0f172a !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-icon {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3);
        }

        .nav-link {
            color: #64748b !important;
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 12px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background: rgba(13, 110, 253, 0.05);
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            background: rgba(13, 110, 253, 0.1);
            font-weight: 600;
        }

        /* Styling tambahan untuk mobile toggler agar lebih clean */
        .navbar-toggler {
            border: none;
            padding: 0;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar {
            min-height: var(--navbar-height);
            background: rgba(255, 255, 255, 0.95) !important;
            /* Ditingkatkan opasitasnya */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            z-index: 1050;
            /* Memastikan di atas konten */
        }

        /* FIX: Memberikan background solid putih saat menu dibuka di HP */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: white;
                margin: 0 -1rem;
                /* Menyeimbangkan padding container */
                padding: 1rem;
                border-radius: 0 0 20px 20px;
                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            }

            /* Menghilangkan paksaan height agar navbar bisa melebar saat menu dibuka */
            .navbar {
                height: auto !important;
            }
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #0f172a !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Card & UI Improvements */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 10px 24px;
            transition: transform 0.2s;
        }

        .btn:active {
            transform: scale(0.98);
        }

        /* Merapikan area footer form di HP */
        .form-footer {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 1.5rem;
            margin: 0 -1.5rem -1.5rem -1.5rem;
            /* Menutup padding container */
            border-top: 1px solid #eee;
            z-index: 100;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            border: none;
        }

        .btn-outline-primary {
            border-width: 2px;
        }

        /* Batasi lebar container agar tidak melebar sampai ujung layar di Desktop */
        .row.justify-content-center {
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-action {
            transition: all 0.2s ease-in-out;
            border-radius: 12px;
            /* Lebih rounded modern */
        }

        .btn-action:hover {
            transform: translateY(-2px);
            /* Efek melayang sedikit */
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
        }

        .hover-underline:hover {
            text-decoration: underline !important;
            color: #dc3545 !important;
            /* Berubah merah saat hover batal */
        }

        /* Mengatur agar teks 'Batal' tidak terlihat seperti tombol biasa */
        .text-muted {
            font-size: 0.9rem;
        }

        .dropdown-menu {
            min-width: 160px;
            max-width: 250px;
            /* Batasi lebar maksimal agar tidak melar */
        }

        .dropdown-item {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Potong teks dengan titik-titik jika terlalu panjang */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('struk.index') }}">
                <div class="brand-icon">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <span>PLN MANAGEMEN</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-2 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto"> <a
                        class="nav-link {{ request()->routeIs('struk.index') ? 'active' : '' }}"
                        href="{{ route('struk.index') }}">
                        <i class="bi bi-grid-1x2"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('struk.create') ? 'active' : '' }}"
                        href="{{ route('struk.create') }}">
                        <i class="bi bi-plus-circle"></i> Input Periode
                    </a>
                    <a class="nav-link {{ request()->routeIs('pelanggan.index') ? 'active' : '' }}"
                        href="{{ route('pelanggan.index') }}">
                        <i class="bi bi-people"></i> Data Pelanggan
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
