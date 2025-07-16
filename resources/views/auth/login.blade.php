@extends('layouts.main')

@section('title', 'Đăng nhập')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Đăng nhập</h2>

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

    <form action="{{ route('auth.login') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Địa chỉ email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <a href="{{ route('auth.forgot.send') }}">Quên mật khẩu?</a>
        </div>

        <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </form>
</div>
@endsection
