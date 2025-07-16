@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Danh sách nhân viên</h2>

    <a href="{{ route('admin.manage-employees.create') }}" class="btn btn-primary mb-3">Thêm nhân viên</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Vai trò</th>
                <th>Lương</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $emp)
                <tr>
                    <td>{{ $emp->first_name }} {{ $emp->last_name }}</td>
                    <td>{{ $emp->email }}</td>
                    <td>{{ $emp->phone }}</td>
                    <td>{{ $emp->role }}</td>
                    <td>{{ number_format($emp->salary) }} VNĐ</td>
                    <td>{{ ucfirst($emp->status) }}</td>
                    <td>
                        <a href="{{ route('admin.manage-employees.edit', $emp->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('admin.manage-employees.destroy', $emp->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xoá?')">Xoá</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
