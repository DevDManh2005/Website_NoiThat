@extends('layouts.main')

@section('title', 'Quên mật khẩu')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Quên mật khẩu</h2>

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

    <form action="{{ route('auth.forgot.send') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Nhập địa chỉ email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <button type="submit" class="btn btn-primary">Gửi mã OTP</button>
    </form>
</div>
@endsection
