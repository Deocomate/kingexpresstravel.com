@extends('admin.layouts.main')
@section('title', 'Quản lý Đơn hàng')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách Đơn hàng</h3>
        </div>
        <div class="card-body">
            <div class="filter-area mb-4 card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Bộ lọc</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tìm kiếm</label>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Tên KH, email, SĐT, tên tour..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="status" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="PENDING" @selected(request('status') == 'PENDING')>Chờ xử lý</option>
                                        <option value="CONFIRMED" @selected(request('status') == 'CONFIRMED')>Đã xác nhận</option>
                                        <option value="COMPLETED" @selected(request('status') == 'COMPLETED')>Đã hoàn thành</option>
                                        <option value="CANCELLED" @selected(request('status') == 'CANCELLED')>Đã hủy</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Khoảng ngày đặt</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" name="date_range" class="form-control date-range-picker"
                                               value="{{ request('date_range') }}" autocomplete="off" readonly
                                               style="cursor: pointer; background-color: #fff;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <button class="btn btn-primary w-100" type="submit">Lọc</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Tên khách hàng</th>
                        <th>Tour đã đặt</th>
                        <th>Ngày đi</th>
                        <th>Tổng tiền</th>
                        <th style="width: 170px;">Ngày đặt</th>
                        <th style="width: 180px;">Trạng thái</th>
                        <th style="width: 200px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $statusTexts = [
                            'PENDING' => 'Chờ xử lý',
                            'CONFIRMED' => 'Đã xác nhận',
                            'COMPLETED' => 'Đã hoàn thành',
                            'CANCELLED' => 'Đã hủy',
                        ];
                    @endphp
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->full_name }}<br><small>{{ $order->phone }}</small></td>
                            <td>{{ $order->tour->name ?? '[Tour đã xóa]' }}</td>
                            <td>{{ $order->departure_date ? $order->departure_date->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ number_format($order->total_price) }} đ</td>
                            <td>{{ optional($order->created_at)->addHours(7)->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                        @foreach($statusTexts as $key => $text)
                                            <option value="{{ $key }}" @selected($order->status == $key)>
                                                {{ $text }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="text-nowrap">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.orders.show', $order) }}">
                                    <i class="fas fa-eye"></i> Xem
                                </a>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.orders.payment.show', $order) }}" title="Thanh toán">
                                    <i class="fas fa-money-check-alt"></i> TT
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order) }}"
                                      method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
                                        <i class="fas fa-trash"></i> Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Không tìm thấy đơn hàng nào.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
