@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Thêm danh mục</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Tên danh mục</label>
            <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Danh mục cha</label>
            <select id="parent_id" name="parent_id" class="form-control">
                <option value="">-- Không có --</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image_file" class="form-label">Tải ảnh lên</label>
            <input type="file" id="image_file" name="image_file" class="form-control">
        </div>

        <div class="mb-3">
            <label for="image_url" class="form-label">Hoặc nhập URL ảnh</label>
            <input type="url" id="image_url" name="image_url" class="form-control" value="{{ old('image_url') }}">
        </div>

        <button type="submit" class="btn btn-primary">Thêm mới</button>
    </form>
</div>
@endsection
