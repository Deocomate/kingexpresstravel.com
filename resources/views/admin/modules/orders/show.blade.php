@extends('admin.layouts.main')
@section('title', 'Chi tiết Đơn hàng #' . $order->id)

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Thông tin khách hàng</h3>
                </div>
                <div class="card-body">
                    <p><strong>Họ tên:</strong> {{ $order->full_name }}</p>
                    <p><strong>Email:</strong> <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
                    <p><strong>Điện thoại:</strong> <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></p>
                    <p><strong>Tài khoản:</strong> {{ $order->user->name ?? 'Khách vãng lai' }}</p>
                    <p><strong>Ghi chú của khách:</strong></p>
                    <div class="p-2 bg-light" style="white-space: pre-wrap;">{{ $order->note ?: 'Không có' }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Thông tin đơn hàng</h3>
                </div>
                <div class="card-body">
                    <p><strong>Tour đã đặt:</strong> {{ $order->tour->name ?? '[Tour đã xóa]' }}</p>
                    <p><strong>Mã tour:</strong> {{ $order->tour->tour_code ?? 'N/A' }}</p>
                    <p><strong>Ngày đi:</strong> {{ $order->departure_date ? $order->departure_date->format('d/m/Y') : 'Chưa xác định' }}</p>
                    <hr>
                    <p><strong>Chi tiết số lượng:</strong></p>
                    <ul class="list-unstyled">
                        <li>- Người lớn (> 11 tuổi): <strong>{{ $order->adult_quantity }}</strong></li>
                        <li>- Trẻ em (5 - 11 tuổi): <strong>{{ $order->child_quantity }}</strong></li>
                        <li>- Trẻ nhỏ (2 - 5 tuổi): <strong>{{ $order->toddler_quantity }}</strong></li>
                        <li>- Em bé (< 2 tuổi): <strong>{{ $order->infant_quantity }}</strong></li>
                    </ul>
                    <hr>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                    <p><strong>Trạng thái:</strong>
                        @php
                            $statusClasses = ['PENDING' => 'badge-warning', 'CONFIRMED' => 'badge-success', 'CANCELLED' => 'badge-danger'];
                            $statusTexts = ['PENDING' => 'Chờ xử lý', 'CONFIRMED' => 'Đã xác nhận', 'CANCELLED' => 'Đã hủy'];
                        @endphp
                        <span class="badge {{ $statusClasses[$order->status] ?? 'badge-secondary' }}">
                            {{ $statusTexts[$order->status] ?? $order->status }}
                        </span>
                    </p>
                    <p><strong>Tổng tiền:</strong> <strong class="text-danger h5">{{ number_format($order->total_price) }} đ</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
@endsection
