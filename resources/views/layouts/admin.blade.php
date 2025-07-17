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
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .header {
            position: sticky;
            top: 0;
            z-index: 1030;
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .main-wrapper {
            display: flex;
            height: calc(100vh - 60px);
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
            padding-top: 1rem;
            overflow-y: auto;
            position: sticky;
            top: 60px;
            height: calc(100vh - 60px);
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar.collapsed .text-label {
            display: none;
        }

        .sidebar a {
            color: #212529;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar.collapsed a i {
            margin: 0 auto;
        }

        .sidebar.collapsed a {
            justify-content: center;
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

        .nav-section.collapsed {
            display: none;
        }

        .content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 30px;
        }

        .toggle-btn {
            border: none;
            background: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #212529;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="left d-flex align-items-center gap-3">
            <h4 class="m-0"><i class="bi bi-speedometer2 me-2"></i>Trang Quản Trị</h4>
            <button class="toggle-btn" id="sidebarToggle"><i class="bi bi-list"></i></button>
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

    <!-- Wrapper -->
    <div class="main-wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="nav-section text-label">Quản lý</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active fw-bold bg-light' : '' }}">
                <i class="bi bi-house-door"></i> <span class="text-label">Dashboard</span>
            </a>
            <hr>
            <!-- Quản lý tài khoản -->
            <div class="accordion" id="accountAccordion">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button bg-white px-3 py-2 shadow-none rounded {{ request()->is('admin/manage-*') ? '' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#accountCollapse">
                            <i class="bi bi-person-gear me-2"></i> <span class="text-label">Quản lý tài khoản</span>
                        </button>
                    </h2>
                    <div id="accountCollapse" class="accordion-collapse collapse {{ request()->is('admin/manage-*') ? 'show' : '' }}">
                        <div class="accordion-body py-1 px-3">
                            <a href="{{ route('admin.manage-admins.index') }}" class="{{ request()->routeIs('admin.manage-admins.*') ? 'active fw-bold bg-light' : '' }}">
                                <i class="bi bi-person-badge"></i> <span class="text-label">Admins</span>
                            </a>
                            <a href="{{ route('admin.manage-employees.index') }}" class="{{ request()->routeIs('admin.manage-employees.*') ? 'active fw-bold bg-light' : '' }}">
                                <i class="bi bi-people"></i> <span class="text-label">Nhân viên</span>
                            </a>
                            <a href="{{ route('admin.manage-customers.index') }}" class="{{ request()->routeIs('admin.manage-customers.*') ? 'active fw-bold bg-light' : '' }}">
                                <i class="bi bi-person-circle"></i> <span class="text-label">Khách hàng</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quản lý cửa hàng -->
            <div class="accordion mt-3" id="shopAccordion">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button bg-white px-3 py-2 shadow-none rounded {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.products.*') ? '' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#shopCollapse">
                            <i class="bi bi-shop-window me-2"></i> <span class="text-label">Quản lý cửa hàng</span>
                        </button>
                    </h2>
                    <div id="shopCollapse" class="accordion-collapse collapse {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.products.*') ? 'show' : '' }}">
                        <div class="accordion-body py-1 px-3">
                            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active fw-bold bg-light' : '' }}">
                                <i class="bi bi-tags"></i> <span class="text-label">Danh mục</span>
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active fw-bold bg-light' : '' }}">
                                <i class="bi bi-box-seam"></i> <span class="text-label">Sản phẩm</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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

        toggleBtn?.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    </script>
    @stack('scripts')
</body>
</html>
