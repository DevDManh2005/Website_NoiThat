@extends('layouts.admin')

@section('title', 'Chi tiết sản phẩm')

@section('content')
<div class="container py-4">
    <h1>Chi tiết sản phẩm: {{ $product->name }}</h1>

    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mb-3">Quay lại danh sách</a>
    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning mb-3">Chỉnh sửa</a>

    <div class="row">
        <div class="col-md-4">
            @if($product->main_image_url)
                <img src="{{ asset($product->main_image_url) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-3">
            @else
                <p class="text-muted">Chưa có ảnh chính</p>
            @endif

            <h5>Ảnh phụ</h5>
            <div class="d-flex flex-wrap gap-2">
                @forelse($product->images as $img)
                    <img src="{{ asset($img->image_url) }}" alt="Ảnh phụ" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                @empty
                    <p class="text-muted">Chưa có ảnh phụ</p>
                @endforelse
            </div>
        </div>

        <div class="col-md-8">
            <table class="table table-borderless">
                <tr><th>ID:</th><td>{{ $product->id }}</td></tr>
                <tr><th>Tên sản phẩm:</th><td>{{ $product->name }}</td></tr>
                <tr><th>Danh mục:</th><td>{{ $product->category ? $product->category->name : '-' }}</td></tr>
                <tr><th>Mô tả:</th><td>{{ $product->description ?: '-' }}</td></tr>
                <tr><th>Giá:</th><td>{{ number_format($product->price, 0, ',', '.') }} đ</td></tr>
                <tr><th>Số lượng kho:</th><td>{{ $product->stock_quantity }}</td></tr>
                <tr><th>Chất liệu:</th><td>{{ $product->material ?: '-' }}</td></tr>
                <tr><th>Kích thước:</th><td>{{ $product->dimensions ?: '-' }}</td></tr>
                <tr><th>Trọng lượng (kg):</th><td>{{ $product->weight ?? '-' }}</td></tr>
                <tr><th>Ngày tạo:</th><td>{{ $product->created_at->format('d/m/Y H:i') }}</td></tr>
                <tr><th>Ngày cập nhật:</th><td>{{ $product->updated_at->format('d/m/Y H:i') }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
