@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Danh sách quản trị viên</h2>
        <a href="{{ route('admin.manage-admins.create') }}" class="btn btn-primary mb-3">Thêm quản trị viên</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->username }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <a href="{{ route('admin.manage-admins.edit', $admin->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('admin.manage-admins.destroy', $admin->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Xác nhận xóa?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection