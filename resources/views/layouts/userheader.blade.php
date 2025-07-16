<nav class="navbar navbar-light bg-white border-bottom py-2">
  <div class="container d-flex align-items-center justify-content-between">

    {{-- Logo --}}
    <a class="navbar-brand me-4 fw-bold" href="#">LOGO</a>

    {{-- Thanh tìm kiếm --}}
    <form class="d-flex flex-grow-1 me-4 position-relative">
      <input class="form-control rounded-pill ps-4 pe-5" type="search" placeholder="Tìm kiếm..." aria-label="Search" />
      <button class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3" type="submit">
        <i class="bi bi-search fs-5"></i>
      </button>
    </form>

    {{-- Icons --}}
    <div class="d-flex align-items-center me-3">
      <a href="#" class="nav-link px-2"><i class="bi bi-cart fs-5"></i></a>
      <a href="#" class="nav-link px-2"><i class="bi bi-heart fs-5"></i></a>
      <a href="#" class="nav-link px-2"><i class="bi bi-person fs-5"></i></a>
    </div>

    {{-- Đăng nhập / Đăng xuất --}}
    <div class="d-flex align-items-center">
      @if (Auth::guard('admin')->check())
        {{-- Admin --}}
        <a href="{{ route('admin.dashboard') }}" class="btn btn-warning me-2">Quản trị</a>
        <form method="POST" action="{{ route('auth.logout') }}">
          @csrf
          <button type="submit" class="btn btn-outline-danger">Đăng xuất</button>
        </form>

      @elseif (Auth::guard('employee')->check())
        {{-- Nhân viên --}}
        <a href="{{ route('employee.dashboard') }}" class="btn btn-info me-2">Nhân viên</a>
        <form method="POST" action="{{ route('auth.logout') }}">
          @csrf
          <button type="submit" class="btn btn-outline-danger">Đăng xuất</button>
        </form>

      @elseif (Auth::guard('web')->check())
        {{-- Khách hàng --}}
        <form method="POST" action="{{ route('auth.logout') }}">
          @csrf
          <button type="submit" class="btn btn-outline-danger">Đăng xuất</button>
        </form>

      @else
        {{-- Chưa đăng nhập --}}
        <a href="{{ route('auth.login.form') }}" class="btn btn-outline-primary me-2">Đăng nhập</a>
        <a href="{{ route('auth.register.form') }}" class="btn btn-primary">Đăng ký</a>
      @endif
    </div>

  </div>
</nav>

{{-- Menu điều hướng thứ hai --}}
<div class="bg-light border-bottom py-2">
  <div class="container">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <a class="nav-link text-uppercase px-3 fw-semibold text-dark" href="{{ url('/') }}">Trang chủ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-uppercase px-3 fw-semibold text-dark" href="{{ url('/gioi-thieu') }}">Giới thiệu</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-uppercase px-3 fw-semibold text-dark" href="{{ url('/shop-products') }}">Sản phẩm</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-uppercase px-3 fw-semibold text-dark" href="{{ url('/tin-tuc') }}">Tin tức</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-uppercase px-3 fw-semibold text-dark" href="{{ url('/lien-he') }}">Liên hệ</a>
      </li>
    </ul>
  </div>
</div>
