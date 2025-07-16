@extends('layouts.main')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Đặt lại mật khẩu</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('auth.reset') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="otp" class="form-label">Mã OTP</label>
            <input type="text" class="form-control" id="otp" name="otp" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu mới</label>
            <input type="password" class="form-control" id="password" name="password" required minlength="6">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="6">
        </div>

        <div class="mb-3 text-end">
            <a href="{{ route('auth.reset.resend') }}">Gửi lại mã OTP</a>
        </div>

        <button type="submit" class="btn btn-primary">Đặt lại mật khẩu</button>
    </form>
</div>
@endsection
