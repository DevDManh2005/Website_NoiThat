@extends('layouts.main') {{-- layout chính đã bao gồm header + footer --}}

@section('title', 'Trang chủ')

@section('content')

    <div class="row text-center mb-5">
        @foreach ([
            ['icon' => 'bi-display', 'label' => 'Nội thất'],
            ['icon' => 'bi-person', 'label' => 'Nhân sự'],
            ['icon' => 'bi-truck', 'label' => 'Vận chuyển'],
            ['icon' => 'bi-laptop', 'label' => 'Thiết bị'],
            ['icon' => 'bi-house', 'label' => 'Văn phòng'],
            ['icon' => 'bi-shop', 'label' => 'Cửa hàng'],
        ] as $category)
        <div class="col-4 col-md-2 mb-3">
            <i class="bi {{ $category['icon'] }} fs-2 text-primary mb-2"></i>
            <div>{{ $category['label'] }}</div>
        </div>
        @endforeach
    </div>

</div>
@endsection
