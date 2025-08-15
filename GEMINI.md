# Phân tích tổng quan dự án: Tour Sales System

Tài liệu này cung cấp một cái nhìn tổng quan về dự án `tour-sales-system` dựa trên phân tích codebase. Mục đích là để AI có thể hiểu nhanh về cấu trúc, công nghệ và các thành phần chính của dự án.

## 1. Tổng quan dự án

- **Tên dự án:** `tour-sales-system`
- **Mục tiêu (dự đoán):** Xây dựng một hệ thống quản lý và bán tour du lịch, bao gồm một trang quản trị (Admin) để quản lý nội dung và một trang cho người dùng (Client).
- **Framework:** Laravel.
- **Nền tảng:** Ứng dụng web.

## 2. Công nghệ sử dụng (Technology Stack)

### Backend
- **Ngôn ngữ:** PHP
- **Framework:** Laravel
- **Database:**
    - **Mặc định:** MariaDB (dựa trên `.env.example`).
    - Hỗ trợ thêm: MySQL, PostgreSQL, SQLite.
- **Quản lý file:** Tích hợp sâu với **CKFinder** (`ckfinder/ckfinder-laravel-package`), cho thấy nhu cầu quản lý file và media (hình ảnh, tài liệu) là rất quan trọng.

### Frontend
- **Template Engine:** Blade (`.blade.php`)
- **Admin Panel:**
    - **Theme:** AdminLTE 3 (sử dụng Bootstrap 4).
    - **JavaScript:** jQuery là thư viện chủ đạo đi kèm với theme.
- **Client Panel:** Chưa có nhiều thông tin, nhưng project đã cài đặt **Tailwind CSS**, có thể sẽ được dùng cho phần này.
- **Build Tool:** Vite (`vite.config.js`) được sử dụng để biên dịch và quản lý assets (CSS, JS).

## 3. Cấu trúc thư mục chính

Dự án tuân theo cấu trúc tiêu chuẩn của Laravel, với một vài điểm đáng chú ý:

- **`app/Http/Controllers`**:
    - Được phân chia rõ ràng thành 3 khu vực: `Admin`, `Api`, và `Client`. Điều này cho thấy sự tách biệt logic giữa các phần của ứng dụng.
- **`app/View/Components`**:
    - Dự án sử dụng rất nhiều Blade Components để tái sử dụng code cho các thành phần UI, đặc biệt là các ô nhập liệu (inputs) và menu. Đây là một practice rất tốt, giúp code view gọn gàng và dễ bảo trì.
- **`resources/views`**:
    - **`admin/`**: Chứa các view cho trang quản trị. Gần đây đã được cấu trúc lại để tách các layout partials (head, header, sidebar, footer, scripts), giúp file layout chính (`main.blade.php`) trở nên tinh gọn.
    - **`client/`**: Khu vực dành cho giao diện người dùng, hiện tại còn trống.
    - **`components/`**: Chứa các file view cho Blade Components, tương ứng với các class trong `app/View/Components`.
- **`routes/web.php`**:
    - Là nơi định nghĩa các route cho cả Admin và Client. Cần chú ý cách tổ chức route để tránh xung đột và dễ quản lý.
- **`config/ckfinder.php`**:
    - File cấu hình rất chi tiết cho CKFinder, cho thấy đây là một phần quan trọng của hệ thống.

## 4. Các tính năng chính (Dự đoán)

- **Hệ thống xác thực:** Đã có middleware cho Admin (`AdminAuthMiddleware`) và Client (`ClientAuthMiddleware`), mặc dù logic bên trong chưa được triển khai.
- **Quản lý nội dung (CMS):** Hệ thống có vẻ được xây dựng để quản lý các nội dung động thông qua các form (được tạo từ Blade Components) và trình soạn thảo (CKEditor/CKFinder).
- **Quản lý Tour:** Chức năng cốt lõi của dự án (chưa được triển khai) sẽ liên quan đến việc tạo, cập nhật, xóa các tour du lịch.
- **Phân hệ Admin và Client:** Hệ thống được thiết kế để có hai giao diện riêng biệt cho người quản trị và người dùng cuối.

## 5. Lưu ý cho AI

- **Ưu tiên sử dụng Blade Components:** Khi thêm các thành phần UI mới, đặc biệt là form, hãy tuân thủ theo cấu trúc component đã có trong `app/View/Components` và `resources/views/components`.
- **Tích hợp CKFinder:** Mọi chức năng liên quan đến upload và quản lý file/hình ảnh đều phải thông qua CKFinder.
- **Tách biệt Admin/Client:** Luôn giữ sự tách biệt rõ ràng về logic (Controllers, Views, Routes) giữa hai phân hệ này.
- **Database chưa có nhiều:** Hiện tại database chỉ có các bảng mặc định của Laravel. Các model và migration cho các tính năng chính (Tours, Bookings, Customers, etc.) cần được tạo mới.
