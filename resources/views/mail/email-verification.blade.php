<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực địa chỉ Email</title>
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
        .content {
            padding: 20px 0;
        }
        .content h2 {
            color: #d97706;
            font-size: 20px;
            margin-top: 0;
        }
        .content p {
            line-height: 1.6;
            font-size: 16px;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            background-color: #f59e0b;
            color: #ffffff;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #d97706;
        }
        .link-container {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 20px;
            word-break: break-all;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>King Express Travel</h1>
    </div>

    <div class="content">
        <h2>Xác thực địa chỉ Email của bạn</h2>
        <p>Chào <strong>{{ $user->name ?? '' }}</strong>,</p>
        <p>Cảm ơn bạn đã đăng ký tài khoản tại King Express Travel. Vui lòng nhấp vào nút bên dưới để xác thực địa chỉ email của bạn và hoàn tất quá trình đăng ký.</p>

        <div class="button-container">
            <a href="{{ $verificationUrl ?? '#' }}" class="button">Xác thực Email</a>
        </div>

        <p>Nếu bạn không thể nhấp vào nút trên, vui lòng sao chép và dán liên kết sau vào trình duyệt của bạn:</p>
        <div class="link-container">
            <a href="{{ $verificationUrl ?? '#' }}" style="color: #f59e0b;">{{ $verificationUrl ?? '' }}</a>
        </div>

        <p style="margin-top: 25px;">Nếu bạn không tạo tài khoản này, vui lòng bỏ qua email này.</p>
        <p>Trân trọng,<br>Đội ngũ King Express Travel</p>
    </div>

    <div class="footer">
        <p><strong>Công ty Du lịch King Express</strong></p>
        <p>Địa chỉ: 239A Hoàng Văn Thụ, P.Phú Nhuận, TP. Hồ Chí Minh.</p>
        <p>Website: kingexpresstravel.com.vn</p>
    </div>
</div>
</body>
</html>
