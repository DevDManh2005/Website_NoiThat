<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Quản Trị</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .main-wrapper {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header .left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header h4 {
            margin: 0;
            font-weight: bold;
        }

        .toggle-btn {
            border: none;
            background: none;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            color: #212529;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
            padding-top: 1rem;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 0;
            padding: 0;
            overflow: hidden;
        }

        .sidebar a {
            color: #212529;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            border-radius: 5px;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #e9ecef;
            color: #0d6efd;
        }

        .nav-section {
            padding: 8px 20px;
            font-size: 0.8rem;
            font-weight: bold;
            color: #6c757d;
            text-transform: uppercase;
        }

        .content {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        /* Optional: Shift content when sidebar is collapsed */
        .sidebar.collapsed + .content {
            padding-left: 30px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                z-index: 999;
                height: 100%;
                left: 0;
                top: 60px;
                background-color: #fff;
                border-right: 1px solid #dee2e6;
            }

            .sidebar.collapsed {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar:not(.collapsed) {
                transform: translateX(0);
            }

            .content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="left">
            <h4><i class="bi bi-speedometer2 me-2"></i>Trang Quản Trị</h4>
             <button class="toggle-btn" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
        </div>
        <div class="right d-flex align-items-center gap-2">
            <a href="{{ url('/') }}" class="btn btn-outline-primary">
                <i class="bi bi-house-door"></i> Trang chủ
            </a>
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </button>
            </form>
        </div>
    </div>

    <!-- Main -->
    <div class="main-wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="nav-section">Quản lý</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
            <a href="{{ route('admin.manage-admins.index') }}" class="{{ request()->routeIs('admin.manage-admins.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Quản lý Admins
            </a>
            <a href="{{ route('admin.manage-employees.index') }}" class="{{ request()->routeIs('admin.manage-employees.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Quản Lý Nhân viên
            </a>
            <a href="{{ route('admin.manage-customers.index') }}" class="{{ request()->routeIs('admin.manage-customers.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Quản Lý Khách hàng
            </a>
        </div>

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    </script>
    @stack('scripts')
</body>
</html>
