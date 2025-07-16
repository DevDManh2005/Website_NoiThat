@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh sách khách hàng</h1>

    <a href="{{ route('admin.manage-customers.create') }}" class="btn btn-primary mb-3">Thêm thành viên</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>
                <th>#</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Địa chỉ</th>
                <th>Phường/Xã</th>
                <th>Quận/Huyện</th>
                <th>Tỉnh/Thành phố</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->ward }}</td>
                    <td>{{ $customer->district }}</td>
                    <td>{{ $customer->city }}</td>
                    <td>
                        @if($customer->is_active)
                            <span class="badge bg-success">Đã kích hoạt</span>
                        @else
                            <span class="badge bg-secondary">Chưa kích hoạt</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.manage-customers.edit', $customer->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                        <form action="{{ route('admin.manage-customers.destroy', $customer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
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
