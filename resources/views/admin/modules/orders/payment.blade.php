@extends('admin.layouts.main')
@section('title', 'Thanh toán cho Đơn hàng #' . $order->id)

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết đơn hàng</h3>
                </div>
                <div class="card-body">
                    <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
                    <p><strong>Khách hàng:</strong> {{ $order->full_name }} ({{ $order->email }})</p>
                    <p><strong>Tour:</strong> {{ optional($order->tour)->name }}</p>
                    <p><strong>Ngày đi:</strong> {{ optional($order->departure_date)->format('d/m/Y') }}</p>
                    <p><strong>Tổng tiền:</strong> <strong class="text-danger">{{ number_format($order->total_price) }} đ</strong></p>
                    <p><strong>Trạng thái đơn hàng:</strong>
                        <span class="badge badge-info">{{ $order->status }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <form action="{{ route('admin.orders.payment.update', $order) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin & Cập nhật thanh toán</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $payment = $order->payment;
                        @endphp

                        <div class="form-group">
                            <label>Phương thức thanh toán</label>
                            <input type="text" class="form-control" value="{{ optional($payment)->method ?? 'Chưa có' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="status">Trạng thái thanh toán</label>
                            <select name="status" id="status" class="form-control">
                                <option value="PENDING" @selected(optional($payment)->status == 'PENDING')>Chờ thanh toán</option>
                                <option value="SUCCESS" @selected(optional($payment)->status == 'SUCCESS')>Đã thanh toán (Thành công)</option>
                                <option value="FAILED" @selected(optional($payment)->status == 'FAILED')>Thanh toán thất bại</option>
                                <option value="CANCELLED" @selected(optional($payment)->status == 'CANCELLED')>Đã hủy</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="transaction_id">Mã giao dịch (nếu có)</label>
                            <input type="text" name="transaction_id" id="transaction_id" class="form-control bg-light" value="{{ old('transaction_id', optional($payment)->transaction_id) }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="note">Ghi chú của Admin</label>
                            <textarea name="note" id="note" class="form-control" rows="3">{{ old('note', optional($payment)->note) }}</textarea>
                        </div>

                        @if(optional($payment)->paid_at)
                            <p class="text-muted">Thanh toán vào lúc: {{ optional($payment->paid_at)->addHours(7)->format('d/m/Y H:i:s') }}</p>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật thanh toán</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
