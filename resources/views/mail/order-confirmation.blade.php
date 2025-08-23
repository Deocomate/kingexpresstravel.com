<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 680px;
            margin: 20px auto;
            padding: 25px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #f59e0b;
        }
        .header h1 {
            color: #f59e0b;
            margin: 0;
            font-size: 28px;
        }
        .content h2 {
            color: #d97706;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-top: 30px;
            font-size: 20px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .details-table td {
            padding: 10px 0;
            vertical-align: top;
            border-bottom: 1px solid #f0f0f0;
        }
        .details-table td:first-child {
            width: 150px;
            font-weight: bold;
            color: #333;
        }
        .price-breakdown {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .price-breakdown th, .price-breakdown td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .price-breakdown th {
            background-color: #f9fafb;
            font-weight: bold;
        }
        .price-breakdown td.align-right, .price-breakdown th.align-right {
            text-align: right;
        }
        .total-section {
            margin-top: 20px;
            padding-top: 15px;
            text-align: right;
        }
        .total-section p {
            margin: 5px 0;
            font-size: 18px;
        }
        .total-section .total-price {
            font-size: 24px;
            font-weight: bold;
            color: #ef4444;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 12px;
            color: #fff;
        }
        .badge-confirmed { background-color: #2563eb; }
        .badge-completed { background-color: #16a34a; }
        .badge-cancelled { background-color: #dc2626; }
        .badge-success { background-color: #16a34a; }
        .badge-failed { background-color: #dc2626; }
    </style>
</head>
<body>
@php
    $orderStatusClasses = [
        'CONFIRMED' => 'badge-confirmed',
        'COMPLETED' => 'badge-completed',
        'CANCELLED' => 'badge-cancelled',
    ];
    $orderStatusTexts = [
        'PENDING'   => 'Chờ xác nhận',
        'CONFIRMED' => 'Đã xác nhận',
        'COMPLETED' => 'Đã hoàn thành',
        'CANCELLED' => 'Đã hủy',
    ];
    $paymentStatusClasses = [
        'SUCCESS'   => 'badge-success',
        'FAILED'    => 'badge-failed',
        'CANCELLED' => 'badge-cancelled',
    ];
    $paymentStatusTexts = [
        'PENDING'   => 'Chờ thanh toán',
        'SUCCESS'   => 'Đã thanh toán',
        'FAILED'    => 'Thanh toán thất bại',
        'CANCELLED' => 'Đã hủy',
    ];
@endphp

<div class="container">
    <div class="header">
        <h1>King Express Travel</h1>
        <p style="margin-top: 5px; font-size: 18px;">Xác nhận đặt tour thành công</p>
    </div>

    <div class="content">
        <p>Chào <strong>{{ $order->full_name ?? '' }}</strong>,</p>
        <p>Cảm ơn bạn đã tin tưởng và đặt tour tại King Express Travel. Chúng tôi đã nhận được yêu cầu của bạn và thông tin chi tiết như sau:</p>

        <h2>1. Thông tin đơn hàng</h2>
        <table class="details-table">
            <tr>
                <td>Mã đơn hàng:</td>
                <td><strong>#{{ $order->id }}</strong></td>
            </tr>
            <tr>
                <td>Ngày đặt:</td>
                <td>{{ $order->created_at ? $order->created_at->addHours(7)->format('d/m/Y H:i:s') : 'N/A' }} (GMT+7)</td>
            </tr>
            <tr>
                <td>Trạng thái:</td>
                <td>
                    @if($order->status === 'PENDING')
                        <span>{{ $orderStatusTexts['PENDING'] }}</span>
                    @else
                        <span class="badge {{ $orderStatusClasses[$order->status] ?? '' }}">
                                {{ $orderStatusTexts[$order->status] ?? $order->status }}
                            </span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Họ và tên:</td>
                <td>{{ $order->full_name ?? '' }}</td>
            </tr>
            <tr>
                <td>Điện thoại:</td>
                <td>{{ $order->phone ?? '' }}</td>
            </tr>
            @if($order->address)
                <tr>
                    <td>Địa chỉ:</td>
                    <td>{{ $order->address }}</td>
                </tr>
            @endif
            <tr>
                <td>Thanh toán:</td>
                <td>
                    {{ $order->payment->method ?? 'Chưa xác định' }} -
                    @if($order->payment)
                        @if($order->payment->status === 'PENDING')
                            <span>{{ $paymentStatusTexts['PENDING'] }}</span>
                        @else
                            <span class="badge {{ $paymentStatusClasses[$order->payment->status] ?? '' }}">
                                    {{ $paymentStatusTexts[$order->payment->status] ?? $order->payment->status }}
                                </span>
                        @endif
                    @else
                        <span>Chưa có thông tin</span>
                    @endif
                </td>
            </tr>
            @if($order->note)
                <tr>
                    <td>Ghi chú:</td>
                    <td>{{ $order->note }}</td>
                </tr>
            @endif
        </table>

        <h2>2. Thông tin tour</h2>
        <table class="details-table">
            <tr>
                <td>Tên tour:</td>
                <td><strong>{{ $order->tour->name ?? '[Không có thông tin]' }}</strong></td>
            </tr>
            <tr>
                <td>Mã tour:</td>
                <td>{{ $order->tour->tour_code ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Ngày khởi hành:</td>
                <td>{{ $order->departure_date ? $order->departure_date->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <td>Thời gian:</td>
                <td>{{ $order->tour->duration ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Điểm đến:</td>
                <td>{{ $order->tour && $order->tour->destinations->isNotEmpty() ? $order->tour->destinations->pluck('name')->join(', ') : 'N/A' }}</td>
            </tr>
        </table>

        <h3 style="margin-top: 20px; font-size: 18px; color: #333;">Chi tiết giá:</h3>
        <table class="price-breakdown">
            <thead>
            <tr>
                <th>Loại khách</th>
                <th class="align-right">Số lượng</th>
                <th class="align-right">Đơn giá</th>
                <th class="align-right">Thành tiền</th>
            </tr>
            </thead>
            <tbody>
            @if($order->adult_quantity > 0)
                <tr>
                    <td><strong>Người lớn (>11 tuổi)</strong></td>
                    <td class="align-right">{{ $order->adult_quantity }}</td>
                    <td class="align-right">{{ number_format($order->tour->price_adult ?? 0) }} đ</td>
                    <td class="align-right">{{ number_format(($order->tour->price_adult ?? 0) * $order->adult_quantity) }} đ</td>
                </tr>
            @endif
            @if($order->child_quantity > 0)
                <tr>
                    <td><strong>Trẻ em (5-11 tuổi)</strong></td>
                    <td class="align-right">{{ $order->child_quantity }}</td>
                    <td class="align-right">{{ number_format($order->tour->price_child ?? 0) }} đ</td>
                    <td class="align-right">{{ number_format(($order->tour->price_child ?? 0) * $order->child_quantity) }} đ</td>
                </tr>
            @endif
            @if($order->toddler_quantity > 0)
                <tr>
                    <td><strong>Trẻ nhỏ (2-5 tuổi)</strong></td>
                    <td class="align-right">{{ $order->toddler_quantity }}</td>
                    <td class="align-right">{{ number_format($order->tour->price_toddler ?? 0) }} đ</td>
                    <td class="align-right">{{ number_format(($order->tour->price_toddler ?? 0) * $order->toddler_quantity) }} đ</td>
                </tr>
            @endif
            @if($order->infant_quantity > 0)
                <tr>
                    <td><strong>Em bé (<2 tuổi)</strong></td>
                    <td class="align-right">{{ $order->infant_quantity }}</td>
                    <td class="align-right">{{ number_format($order->tour->price_infant ?? 0) }} đ</td>
                    <td class="align-right">{{ number_format(($order->tour->price_infant ?? 0) * $order->infant_quantity) }} đ</td>
                </tr>
            @endif
            </tbody>
        </table>

        <div class="total-section">
            <p>Tổng cộng:</p>
            <p class="total-price">{{ number_format($order->total_price ?? 0) }} đ</p>
        </div>

        <p style="margin-top: 25px;">Nhân viên của chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận lại đơn hàng và hướng dẫn các bước tiếp theo. Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ hotline <strong>1900 1177</strong>.</p>
    </div>

    <div class="footer">
        <p><strong>Công ty Du lịch King Express</strong></p>
        <p>Địa chỉ: 239A Hoàng Văn Thụ, P.Phú Nhuận, TP. Hồ Chí Minh.</p>
        <p>Website: kingexpresstravel.com.vn</p>
    </div>
</div>
</body>
</html>
