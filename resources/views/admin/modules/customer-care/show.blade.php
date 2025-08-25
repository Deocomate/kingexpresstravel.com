@extends('admin.layouts.main')
@section('title', 'Chi tiết Liên hệ')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Thông tin liên hệ</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Họ tên:</strong> {{ $customerCare->full_name }}</p>
                    <p><strong>Email:</strong> <a href="mailto:{{ $customerCare->email }}">{{ $customerCare->email }}</a></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Điện thoại:</strong> <a href="tel:{{ $customerCare->phone }}">{{ $customerCare->phone }}</a></p>
                    <p><strong>Ngày gửi:</strong> {{ optional($customerCare->created_at)->addHours(7)->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
            <hr>
            <h5><strong>Chủ đề:</strong> {{ $customerCare->subject }}</h5>
            <div class="message-content mt-3 p-3 bg-light" style="white-space: pre-wrap; border-radius: 5px;">{{ $customerCare->message }}</div>
            @if($customerCare->note)
                <hr>
                <h5><strong>Ghi chú của khách:</strong></h5>
                <div class="message-content mt-3 p-3 bg-light" style="white-space: pre-wrap; border-radius: 5px;">{{ $customerCare->note }}</div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.customer-care.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
@endsection
