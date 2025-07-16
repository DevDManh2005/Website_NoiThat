@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Thêm khách hàng mới</h1>

    <form action="{{ route('admin.manage-customers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Họ</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tên</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Điện thoại</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Địa chỉ</label>
            <input type="text" name="address" class="form-control">
        </div>

        <div class="mb-3">
            <label for="province">Tỉnh/Thành phố</label>
            <select id="province" name="city" class="form-control" required>
                <option value="">-- Chọn Tỉnh/Thành phố --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="district">Quận/Huyện</label>
            <select id="district" name="district" class="form-control" disabled required>
                <option value="">-- Chọn Quận/Huyện --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ward">Phường/Xã</label>
            <select id="ward" name="ward" class="form-control" disabled required>
                <option value="">-- Chọn Phường/Xã --</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nhập lại mật khẩu</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-primary">Thêm</button>
        <a href="{{ route('admin.manage-customers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    let provinces = [];

    // Load danh sách tỉnh/thành
    fetch('https://provinces.open-api.vn/api/p/')
        .then(res => res.json())
        .then(data => {
            provinces = data;
            data.forEach(province => {
                provinceSelect.innerHTML += `<option value="${province.name}" data-code="${province.code}">${province.name}</option>`;
            });
        });

    // Khi chọn tỉnh → load quận
    provinceSelect.addEventListener('change', function () {
        const selectedProvince = provinces.find(p => p.name === this.value);
        districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
        wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
        wardSelect.disabled = true;
        districtSelect.disabled = true;

        if (selectedProvince) {
            fetch(`https://provinces.open-api.vn/api/p/${selectedProvince.code}?depth=2`)
                .then(res => res.json())
                .then(data => {
                    data.districts.forEach(d => {
                        districtSelect.innerHTML += `<option value="${d.name}" data-code="${d.code}">${d.name}</option>`;
                    });
                    districtSelect.disabled = false;
                });
        }
    });

    // Khi chọn quận → load xã
    districtSelect.addEventListener('change', function () {
        const selectedDistrictCode = this.options[this.selectedIndex].dataset.code;
        wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
        wardSelect.disabled = true;

        if (selectedDistrictCode) {
            fetch(`https://provinces.open-api.vn/api/d/${selectedDistrictCode}?depth=2`)
                .then(res => res.json())
                .then(data => {
                    data.wards.forEach(w => {
                        wardSelect.innerHTML += `<option value="${w.name}">${w.name}</option>`;
                    });
                    wardSelect.disabled = false;
                });
        }
    });
});
</script>
@endpush
