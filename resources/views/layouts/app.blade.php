<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Struk PLN</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
        }

        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
        }

        .card {
            border: none;
            border-radius: 16px;
            /* Lebih rounded */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 10px 15px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            border-color: #3b82f6;
        }

        .table thead th {
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            color: #4b5563;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        /* Pagination Styling agar lebih rounded */
        .pagination {
            --bs-pagination-border-radius: 10px;
        }

        .pagination .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        /* Background Soft Colors */
        .bg-primary-subtle {
            background-color: #e0e7ff !important;
        }

        .bg-success-subtle {
            background-color: #dcfce7 !important;
        }

        .bg-secondary-subtle {
            background-color: #f3f4f6 !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('struk.index') }}">
                <i class="bi bi-lightning-charge-fill text-warning"></i> PLN MANAGEMEN
            </a>
            <div class="navbar-nav">
                <a class="nav-link {{ request()->routeIs('struk.index') ? 'active' : '' }}"
                    href="{{ route('struk.index') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('struk.create') ? 'active' : '' }}"
                    href="{{ route('struk.create') }}">Input Periode</a>
                <a class="nav-link {{ request()->routeIs('pelanggan.index') ? 'active' : '' }}"
                    href="{{ route('pelanggan.index') }}">Data Pelanggan</a>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
