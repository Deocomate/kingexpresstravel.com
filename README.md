# King Express Travel - Hệ thống Bán Tour Du lịch

Đây là dự án backend và trang quản trị cho hệ thống bán tour du lịch King Express Travel, được xây dựng trên nền tảng
Laravel.

---

## 🚀 Công nghệ sử dụng

* **Backend:** PHP / Laravel
* **Frontend (Templates):** Blade
* **Quản lý dependencies:** Composer
* **Cơ sở dữ liệu:** (Giả định là MySQL/MariaDB)

---

## ✨ Tính năng chính

* Quản lý Tour (Thêm, sửa, xóa, quản lý hình ảnh...)
* Quản lý Đơn hàng (Bookings)
* Quản lý Người dùng (Khách hàng, Quản trị viên) & Phân quyền
* Quản lý Danh mục Tour
* Quản lý Điểm đến
* Quản lý Tin tức / Blog
* Trang quản trị (Admin Panel) đầy đủ chức năng
* Trang Client (Website bán hàng)
* Hệ thống API (dùng cho mobile app hoặc bên thứ ba)
* Xác thực (Đăng nhập, Đăng ký, Quên mật khẩu...)

---

## 📂 Cấu trúc dự án (Quan trọng)

Để nhanh chóng nắm bắt dự án, đây là các thư mục và file quan trọng nhất:

* `app/Http/Controllers/Admin/`: Chứa toàn bộ logic xử lý cho **Trang Quản Trị**.
* `app/Http/Controllers/Client/`: Chứa logic xử lý cho **Trang Khách Hàng (Website)**.
* `app/Http/Controllers/Api/`: Chứa logic xử lý cho các **API endpoint**.
* `app/Models/`: Chứa các Eloquent Model (e.g., `Tour`, `Order`, `User`).
* `app/Http/Requests/`: Chứa các Form Request Validation (validate dữ liệu đầu vào).
* `database/migrations/`: Chứa các file định nghĩa cấu trúc bảng CSDL.
* `resources/views/admin/`: Chứa các file Blade template cho **Trang Quản Trị**.
* `resources/views/client/`: Chứa các file Blade template cho **Trang Khách Hàng**.
* `resources/views/emails/`: Chứa các template email (e.g., quên mật khẩu).
* `routes/admin.php`: Định nghĩa các route cho **Trang Quản Trị** (thường có prefix `/admin`).
* `routes/web.php`: Định nghĩa các route cho **Trang Khách Hàng**.
* `routes/api.php`: Định nghĩa các route cho **API**.

---

## 🛠️ Hướng dẫn cài đặt và chạy dự án

1. **Clone dự án:**
   ```bash
   git clone [repository_url]
   cd tour-sales-system
   ```

2. **Cài đặt dependencies:**
   ```bash
   composer install
   ```

3. **Cấu hình file môi trường:**
    * Sao chép file `.env.example` thành `.env`:
        ```bash
        cp .env.example .env
        ```
    * Mở file `.env` và cấu hình các thông tin cần thiết.

4. **Sinh khóa ứng dụng (App Key):**
   ```bash
   php artisan key:generate
   ```

5. **Cấu hình CSDL (Database) trong `.env`:**
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ten_database
   DB_USERNAME=root
   DB_PASSWORD=password_cua_ban
   ```

6. **Chạy Migration (và Seeder nếu có):**
    * Tạo các bảng trong CSDL:
        ```bash
        php artisan migrate
        ```
    * (Tùy chọn) Chạy Seeder để thêm dữ liệu mẫu:
        ```bash
        php artisan db:seed
        ```

7. **Liên kết thư mục Storage:**
   ```bash
   php artisan storage:link
   ```

8. **(Tùy chọn) Cài đặt Frontend (nếu có):**
   ```bash
   npm install
   npm run dev
   ```

9. **Khởi chạy máy chủ local:**
   ```bash
   php artisan serve
   ```
   > Ứng dụng sẽ chạy tại: `http://127.0.0.1:8000`

---

## 🔑 Biến môi trường (.env) quan trọng

Ngoài cấu hình CSDL, hãy chắc chắn bạn đã thiết lập các biến sau:

* `APP_URL`: URL chính của ứng dụng (e.g., `http://127.0.0.1:8000`). Rất quan trọng cho việc tạo link (như link reset
  mật khẩu).
* `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`: Cấu hình để gửi
  email (ví dụ: Mailtrap, SendGrid, ...).

---

## API Endpoints

* Các API endpoint được định nghĩa trong `routes/api.php`.
* Tất cả các response đều trả về định dạng JSON.
* (Ghi chú thêm về cách xác thực API - ví dụ: Sanctum, Passport - nếu có).
