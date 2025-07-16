# Website_NoiThat – Hướng Dẫn Cài Đặt Dự Án Laravel

## 📦 Yêu cầu hệ thống
- PHP 8.2 trở lên (khuyến nghị dùng XAMPP 8.2.12)
- Composer
- Trình duyệt web
- Kết nối Supabase PostgreSQL

---

## 🛠️ Các bước cài đặt

### Bước 1: Cài đặt XAMPP
Tải và cài XAMPP 8.2.12 tại:  
🔗 https://www.apachefriends.org/download.html

---

### Bước 2: Cài đặt Composer
Tải và cài Composer tại:  
🔗 https://getcomposer.org/download/

---

### Bước 3: Kích hoạt các PHP extension cần thiết
1. Mở **XAMPP** → **Config** → **php.ini**.
2. Tìm và bỏ dấu `;` trước các dòng sau:

    ```ini
    extension=pdo_pgsql
    extension=pgsql
    extension=zip
    ```

3. Lưu lại (`Ctrl + S`) và khởi động lại Apache nếu đang chạy.

---

### Bước 4: Cài đặt dự án Laravel

Mở terminal (hoặc `Command Prompt`) tại thư mục chứa mã nguồn Laravel:

```bash
composer install
copy .env.example .env

#Cấu hình cơ sở dữ liệu (Supabase)

DB_CONNECTION=pgsql
DB_HOST=aws-0-ap-southeast-1.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.bjuqjcqhenxjybnxnayg
DB_PASSWORD=websitenoithat2025

# Cấu hình email (SMTP Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=manhldpd10554@gmail.com
MAIL_PASSWORD=kdqmjjiavplpsgju
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=manhldpd10554@gmail.com
MAIL_FROM_NAME="Website Bán Nội Thất"
OTP_EXPIRE_MINUTES=10

```
### Bước 5:  Tạo Application Key
```bash
php artisan key:generate

```
### Bước 6:  Khởi chạy laravel
```bash
php artisan serve
