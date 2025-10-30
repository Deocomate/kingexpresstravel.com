# Hệ thống Bán Tour - Hướng dẫn cho AI Agent

Tài liệu này cung cấp hướng dẫn cần thiết cho các AI agent lập trình làm việc trên hệ thống bán tour của King Express Travel. Việc hiểu rõ các quy ước này là rất quan trọng để làm việc hiệu quả.

**Lưu ý quan trọng: Luôn luôn trả lời và trao đổi bằng tiếng Việt.**

## 1. Kiến trúc dự án

Đây là một ứng dụng Laravel 12 nguyên khối (monolithic) phục vụ ba khu vực riêng biệt từ một codebase duy nhất:
1.  **Trang web Khách hàng (Client):** Trang web công khai nơi người dùng duyệt và đặt tour.
2.  **Trang Quản trị (Admin Panel):** Backend toàn diện để quản lý tour, đơn hàng, người dùng và nội dung.
3.  **API:** Một tập hợp các endpoint, có thể dành cho việc tích hợp ứng dụng di động trong tương lai hoặc các dịch vụ của bên thứ ba.

### Cấu trúc thư mục chính:

-   **Controllers:** Logic được phân tách nghiêm ngặt theo từng khu vực:
    -   `app/Http/Controllers/Client/`: Xử lý toàn bộ logic cho trang web khách hàng.
    -   `app/Http/Controllers/Admin/`: Chứa toàn bộ logic cho trang quản trị.
    -   `app/Http/Controllers/Api/`: Dành cho các API endpoint.
-   **Views (Blade Templates):** Các template frontend cũng được phân tách:
    -   `resources/views/client/`: Dành cho trang web khách hàng.
    -   `resources/views/admin/`: Dành cho trang quản trị.
-   **Routes:** Tất cả các route được định nghĩa trong `routes/web.php`.
    -   Các route cho client được định nghĩa ở cấp cao nhất.
    -   Các route cho admin được nhóm dưới tiền tố `/admin`, tiền tố tên `admin.`, và được bảo vệ bởi `AdminAuthMiddleware`.
-   **Models:** Tất cả các Eloquent model được đặt trong `app/Models/`.

## 2. Quy trình làm việc của Lập trình viên

### Môi trường phát triển cục bộ

Lệnh chính để khởi động môi trường phát triển cục bộ là:

```bash
# Lấy từ file composer.json
composer run dev
```

Lệnh này sử dụng `concurrently` để chạy ba tiến trình cần thiết:
1.  `php artisan serve`: Máy chủ phát triển của Laravel.
2.  `php artisan queue:listen`: Worker xử lý hàng đợi cho các công việc chạy nền.
3.  `npm run dev`: Máy chủ Vite để tải lại nóng (hot-reloading) các tài sản frontend.

### Kiểm thử (Testing)

Để chạy bộ kiểm thử, sử dụng lệnh sau:

```bash
# Lấy từ file composer.json
composer test
```

Lệnh này thực thi các bài kiểm thử PHPUnit của dự án được định nghĩa trong thư mục `tests/`.

### Cơ sở dữ liệu

-   **Migrations:** Các thay đổi về schema cơ sở dữ liệu được quản lý thông qua hệ thống migration của Laravel. Các file nằm trong `database/migrations/`. Sử dụng `php artisan migrate` để áp dụng chúng.
-   **Seeding:** Cơ sở dữ liệu có thể được điền dữ liệu mẫu bằng cách sử dụng các seeder từ `database/seeders/`. Chạy `php artisan db:seed`.

## 3. Các thư viện và quy ước chính

-   **Frontend:** Dự án sử dụng **Vite** để build các tài sản frontend với **Tailwind CSS**. Các file nguồn frontend nằm trong `resources/css/` và `resources/js/`.
-   **Xác thực:**
    -   Tồn tại các hệ thống xác thực riêng biệt cho khách hàng và quản trị viên (`ClientAuthController` vs. `AdminAuthController`).
    -   Khu vực quản trị được bảo vệ bởi `App\Http\Middleware\Auth\AdminAuthMiddleware`.
-   **Email:** Email được gửi bằng dịch vụ **Resend** thông qua gói `resend/resend-php`. Các mẫu email nằm trong `app/Mail/` và `resources/views/emails/`.
-   **Quản lý file:** Gói **CKFinder** (`ckfinder/ckfinder-laravel-package`) được sử dụng, có khả năng cho các trình soạn thảo văn bản đa phương tiện trong trang quản trị.
-   **Đăng nhập mạng xã hội:** Chức năng xác thực bằng Google được triển khai bằng `laravel/socialite`. Xem tại `Client\GoogleAuthController`.
-   **Phong cách code (Code Style):** Dự án sử dụng `laravel/pint` để định dạng code. Đảm bảo các đóng góp của bạn tuân thủ tiêu chuẩn của nó.

Trước khi thực hiện thay đổi, vui lòng xem lại các controller và route có liên quan để hiểu rõ bối cảnh cụ thể.
