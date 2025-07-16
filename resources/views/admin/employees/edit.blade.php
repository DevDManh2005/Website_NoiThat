@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>Cập nhật nhân viên</h2>

        <form action="{{ route('admin.manage-employees.update', $employee->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label>Họ</label>
                <input type="text" name="first_name" class="form-control" value="{{ $employee->first_name }}" required>
            </div>

            <div class="mb-3">
                <label>Tên</label>
                <input type="text" name="last_name" class="form-control" value="{{ $employee->last_name }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $employee->email }}" required>
            </div>

            <div class="mb-3">
                <label>Số điện thoại</label>
                <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}">
            </div>

            <div class="mb-3">
                <label>Mật khẩu (bỏ trống nếu không đổi)</label>
                <input type="password" name="password" class="form-control">
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
                <input type="number" name="salary" class="form-control" value="{{ $employee->salary }}">
            </div>

            <div class="mb-3">
                <label>Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ $employee->status == 'inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.manage-employees.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection