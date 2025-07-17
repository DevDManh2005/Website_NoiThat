@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="container py-4">
    <h1>Danh sách sản phẩm</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Thêm sản phẩm mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Ảnh chính</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Kho</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    @if($product->main_image_url)
                        <img src="{{ asset($product->main_image_url) }}" alt="{{ $product->name }}" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                        <span class="text-muted">Chưa có ảnh</span>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category ? $product->category->name : '-' }}</td>
                <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                <td>{{ $product->stock_quantity }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info">Xem</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xoá sản phẩm này?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Xoá</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">Không có sản phẩm nào.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
</div>
@endsection
