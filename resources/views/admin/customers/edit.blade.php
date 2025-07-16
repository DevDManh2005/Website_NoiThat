@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Chỉnh sửa khách hàng</h1>

    <form action="{{ route('admin.manage-customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Họ</label>
            <input type="text" name="first_name" value="{{ old('first_name', $customer->first_name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tên</label>
            <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Điện thoại</label>
            <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Địa chỉ</label>
            <input type="text" name="address" value="{{ old('address', $customer->address) }}" class="form-control">
        </div>

        <!-- Tỉnh/Thành phố -->
        <div class="mb-3">
            <label for="province">Tỉnh/Thành phố</label>
            <select id="province" name="city" class="form-control" required>
                <option value="">-- Chọn Tỉnh/Thành phố --</option>
            </select>
        </div>

        <!-- Quận/Huyện -->
        <div class="mb-3">
            <label for="district">Quận/Huyện</label>
            <select id="district" name="district" class="form-control" required disabled>
                <option value="">-- Chọn Quận/Huyện --</option>
            </select>
        </div>

        <!-- Phường/Xã -->
        <div class="mb-3">
            <label for="ward">Phường/Xã</label>
            <select id="ward" name="ward" class="form-control" required disabled>
                <option value="">-- Chọn Phường/Xã --</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Mật khẩu (bỏ qua nếu không đổi)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.manage-customers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');
        const wardSelect = document.getElementById('ward');

        const customerProvince = @json($customer->city);
        const customerDistrict = @json($customer->district);
        const customerWard = @json($customer->ward);

        let provinces = [];

        // Load provinces
        await fetch('https://provinces.open-api.vn/api/p/')
            .then(res => res.json())
            .then(data => {
                provinces = data;
                data.forEach(province => {
                    const selected = (province.name === customerProvince) ? 'selected' : '';
                    provinceSelect.innerHTML += `<option value="${province.name}" data-code="${province.code}" ${selected}>${province.name}</option>`;
                });
            });

        // Trigger district load if province existed
        const selectedProvince = provinces.find(p => p.name === customerProvince);
        if (selectedProvince) {
            await fetch(`https://provinces.open-api.vn/api/p/${selectedProvince.code}?depth=2`)
                .then(res => res.json())
                .then(data => {
                    districtSelect.disabled = false;
                    data.districts.forEach(d => {
                        const selected = (d.name === customerDistrict) ? 'selected' : '';
                        districtSelect.innerHTML += `<option value="${d.name}" data-code="${d.code}" ${selected}>${d.name}</option>`;
                    });
                });
        }

        // Trigger ward load if district existed
        const selectedDistrict = districtSelect.querySelector('option[selected]');
        if (selectedDistrict) {
            await fetch(`https://provinces.open-api.vn/api/d/${selectedDistrict.dataset.code}?depth=2`)
                .then(res => res.json())
                .then(data => {
                    wardSelect.disabled = false;
                    data.wards.forEach(w => {
                        const selected = (w.name === customerWard) ? 'selected' : '';
                        wardSelect.innerHTML += `<option value="${w.name}" ${selected}>${w.name}</option>`;
                    });
                });
        }

        // Province change
        provinceSelect.addEventListener('change', function () {
            const province = provinces.find(p => p.name === this.value);
            districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
            wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
            wardSelect.disabled = true;
            districtSelect.disabled = true;

            if (province) {
                fetch(`https://provinces.open-api.vn/api/p/${province.code}?depth=2`)
                    .then(res => res.json())
                    .then(data => {
                        data.districts.forEach(d => {
                            districtSelect.innerHTML += `<option value="${d.name}" data-code="${d.code}">${d.name}</option>`;
                        });
                        districtSelect.disabled = false;
                    });
            }
        });

        // District change
        districtSelect.addEventListener('change', function () {
            const districtCode = this.options[this.selectedIndex].dataset.code;
            wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
            wardSelect.disabled = true;

            if (districtCode) {
                fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
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
