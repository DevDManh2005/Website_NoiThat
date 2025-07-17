@extends('layouts.admin')

@section('content')
<div class="container my-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Chỉnh sửa sản phẩm </h3>
      <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>  
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Form fields --}}
        @include('admin.products._form', ['product' => $product])

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
