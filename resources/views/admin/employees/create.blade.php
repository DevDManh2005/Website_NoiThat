@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>Thêm nhân viên mới</h2>

        <form action="{{ route('admin.manage-employees.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Họ</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tên</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Số điện thoại</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <select name="role" required>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ old('role', $employee->role ?? '') == $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>

            <div class="mb-3">
                <label>Lương</label>
                <input type="number" name="salary" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Thêm</button>
            <a href="{{ route('admin.manage-employees.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection