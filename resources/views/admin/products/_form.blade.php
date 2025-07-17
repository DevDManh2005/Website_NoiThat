@csrf

{{-- ========== THÔNG TIN CƠ BẢN ========== --}}
<div class="card mb-4">
    <div class="card-header fw-bold">Thông tin cơ bản</div>
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Danh mục</label>
            <select class="form-select" name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                @foreach ($categories as $parent)
                    <option value="{{ $parent->id }}" {{ old('category_id', optional($product)->category_id) == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                    @foreach ($parent->children as $child)
                        <option value="{{ $child->id }}" {{ old('category_id', optional($product)->category_id) == $child->id ? 'selected' : '' }}>
                            └── {{ $child->name }}
                        </option>
                    @endforeach
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}"
                required>
        </div>

        <div class="col-12">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control"
                rows="4">{{ old('description', $product->description ?? '') }}</textarea>
        </div>
    </div>
</div>

{{-- ========== THÔNG SỐ KỸ THUẬT ========== --}}
<div class="card mb-4">
    <div class="card-header fw-bold">Thông số kỹ thuật</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <label class="form-label">Giá (VNĐ)</label>
            <input type="number" name="price" class="form-control" step="0.01"
                value="{{ old('price', $product->price ?? '') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Số lượng</label>
            <input type="number" name="stock_quantity" class="form-control"
                value="{{ old('stock_quantity', $product->stock_quantity ?? '') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Chất liệu</label>
            <input type="text" name="material" class="form-control"
                value="{{ old('material', $product->material ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Kích thước</label>
            <input type="text" name="dimensions" class="form-control"
                value="{{ old('dimensions', $product->dimensions ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Trọng lượng (kg)</label>
            <input type="number" step="0.01" name="weight" class="form-control"
                value="{{ old('weight', $product->weight ?? '') }}">
        </div>
    </div>
</div>

{{-- ========== ẢNH CHÍNH ========== --}}
<div class="card mb-4">
    <div class="card-header fw-bold">Ảnh chính</div>
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Tải ảnh từ máy</label>
            <input type="file" name="main_image_file" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Hoặc nhập URL ảnh</label>
            <input type="text" name="main_image_url" class="form-control"
                value="{{ old('main_image_url', $product->main_image_url ?? '') }}">
        </div>

        @if (!empty($product->main_image_url))
            <div class="col-12">
                <label class="form-label d-block">Ảnh hiện tại</label>
                <div class="position-relative d-inline-block">
                    <img src="{{ asset($product->main_image_url) }}" class="img-thumbnail" style="max-height: 150px;">
                    <button type="button" class="btn btn-sm btn-light view-image-btn position-absolute top-0 end-0 m-1"
                        data-src="{{ asset($product->main_image_url) }}" title="Xem ảnh">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ========== ẢNH PHỤ ========== --}}
<div class="card mb-4">
    <div class="card-header fw-bold">Ảnh phụ</div>
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Tải nhiều ảnh</label>
            <input type="file" name="additional_images[]" class="form-control" multiple>
        </div>

        <div class="col-md-6">
            <label class="form-label">Hoặc nhập URL ảnh phụ (1 dòng mỗi ảnh)</label>
            <textarea name="additional_image_urls" class="form-control"
                rows="5">{{ old('additional_image_urls') }}</textarea>
        </div>

        @if (!empty($product->images) && $product->images->count())
            <div class="col-12 mt-3">
                <label class="form-label d-block">Ảnh phụ hiện có</label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach ($product->images as $image)
                        <div class="position-relative border rounded shadow-sm overflow-hidden"
                            style="width: 120px; height: 120px;">

                            {{-- Ảnh --}}
                            <img src="{{ asset($image->image_url) }}" class="w-100 h-100" style="object-fit: cover;">

                            {{-- Container hành động --}}
                            <div class="image-actions position-absolute top-0 start-0 end-0 d-flex justify-content-between p-1"
                                style="background: rgba(0,0,0,0.4);">
                                {{-- Nút xem --}}
                                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal"
                                    data-bs-target="#imagePreviewModal" data-src="{{ asset($image->image_url) }}"
                                    title="Xem ảnh">
                                    <i class="bi bi-eye"></i>
                                </button>

                                {{-- Nút xoá --}}
                                <form method="POST" action="{{ route('admin.products.deleteImage', $image->id) }}"
                                    onsubmit="return confirm('Bạn có chắc muốn xoá ảnh này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xoá ảnh">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ========== NÚT LƯU ========== --}}
<div class="text-end">
    <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
</div>

{{-- ========== MODAL HIỂN ẢNH ========== --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img src="" alt="Preview" id="previewImage" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    const imagePreviewModal = document.getElementById('imagePreviewModal');
    imagePreviewModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const imageSrc = button.getAttribute('data-src');
        const image = imagePreviewModal.querySelector('#previewImage');
        image.setAttribute('src', imageSrc);
    });
</script>

@endpush