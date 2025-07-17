@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Quản lý danh mục</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Danh mục</li>
    </ol>

    <div class="mb-3">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm danh mục
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-table"></i> Danh sách danh mục</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;"></th>
                        <th style="width: 50px;">ID</th>
                        <th style="width: 70px;">Ảnh</th>
                        <th>Tên danh mục</th>
                        <th style="width: 20%;">Mô tả</th>
                        <th style="width: 160px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        {{-- Danh mục cha --}}
                        <tr class="category-row" data-bs-toggle="collapse" data-bs-target="#child-{{ $category->id }}" style="cursor: pointer;">
                            <td class="text-center">
                                <i class="bi bi-chevron-down" id="icon-{{ $category->id }}"></i>
                            </td>
                            <td>{{ $category->id }}</td>
                            <td>
                                @if ($category->image)
                                    <img src="{{ asset($category->image) }}" width="50" height="50" class="rounded" style="object-fit: cover;">
                                @else
                                    <span class="text-muted">Không</span>
                                @endif
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Danh mục con --}}
                        <tr class="collapse category-children" id="child-{{ $category->id }}">
                            <td colspan="6" class="p-0">
                                <div class="p-3 border rounded bg-white shadow-sm mx-2 my-2" style="animation: fadeSlide 0.4s ease;">
                                    @if($category->children->isEmpty())
                                        <div class="text-center text-muted">Không có danh mục con.</div>
                                    @else
                                        <table class="table table-sm table-bordered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 50px;">ID</th>
                                                    <th style="width: 70px;">Ảnh</th>
                                                    <th>Tên danh mục</th>
                                                    <th style="width: 20%;">Mô tả</th>
                                                    <th>Danh mục cha</th>
                                                    <th style="width: 160px;">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($category->children as $child)
                                                    <tr>
                                                        <td>{{ $child->id }}</td>
                                                        <td>
                                                            @if ($child->image)
                                                                <img src="{{ asset($child->image) }}" width="50" height="50" class="rounded" style="object-fit: cover;">
                                                            @else
                                                                <span class="text-muted">Không</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $child->name }}</td>
                                                        <td>{{ $child->description }}</td>
                                                        <td>{{ $category->name }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.categories.edit', $child->id) }}" class="btn btn-sm btn-warning">
                                                                <i class="bi bi-pencil-square"></i> Sửa
                                                            </a>
                                                            <form action="{{ route('admin.categories.destroy', $child->id) }}" method="POST" class="d-inline"
                                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="bi bi-trash"></i> Xoá
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@keyframes fadeSlide {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('.category-row').forEach(row => {
        row.addEventListener('click', function () {
            const id = this.getAttribute('data-bs-target').replace('#child-', '');
            const icon = document.getElementById('icon-' + id);
            icon.classList.toggle('bi-chevron-down');
            icon.classList.toggle('bi-chevron-up');
        });
    });
</script>
@endpush
