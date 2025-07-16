@extends('layouts.main')

@section('title', 'Xác minh OTP')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Xác minh tài khoản</h2>

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

    {{-- Form xác minh OTP --}}
    <form action="{{ route('auth.otp.verify') }}" method="POST" class="mb-3">
        @csrf
        <div class="mb-3">
            <label for="otp" class="form-label">Nhập mã OTP</label>
            <input type="text" class="form-control" id="otp" name="otp" required maxlength="6" pattern="\d{6}">
        </div>
        <button type="submit" class="btn btn-success">Xác minh</button>
    </form>

    {{-- Form gửi lại mã OTP --}}
    <form action="{{ route('auth.otp.resend') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-link p-0">Gửi lại mã OTP</button>
    </form>
</div>
@endsection
