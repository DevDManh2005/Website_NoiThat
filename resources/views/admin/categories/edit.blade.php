@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Chỉnh sửa danh mục</h2>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tên danh mục</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $category->name) }}">
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Danh mục cha</label>
            <select name="parent_id" class="form-control">
                <option value="">-- Không có --</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh hiện tại</label><br>
            @if ($category->image)
                <img src="{{ asset($category->image) }}" alt="Category Image" style="width: 120px;">
            @else
                <p><i>Không có ảnh</i></p>
            @endif
        </div>

        <div class="mb-3">
            <label for="image_file" class="form-label">Tải ảnh mới lên</label>
            <input type="file" name="image_file" class="form-control">
        </div>

        <div class="mb-3">
            <label for="image_url" class="form-label">Hoặc nhập URL ảnh mới</label>
            <input type="url" name="image_url" class="form-control" value="{{ old('image_url') }}">
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>
@endsection
