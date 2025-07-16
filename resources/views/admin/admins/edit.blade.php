@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Chỉnh sửa quản trị viên</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('admin.manage-admins.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="username">Tên đăng nhập</label>
                <input type="text" name="username" class="form-control" value="{{ old('username', $admin->username) }}" required>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
            </div>
            <div class="mb-3">
                <label for="password">Mật khẩu mới (bỏ trống nếu không đổi)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.manage-admins.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
