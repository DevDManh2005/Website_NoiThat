# Website_NoiThat
Lần đầu tải và sử dụng code laravel php
Bước 1 
Cài đặt các package PHP bằng Composer
composer install
Bước 2
Tạo application key
php artisan key:generate
Bước 3
Cấu hình quyền ghi cho thư mục storage và bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
Bước 4
Chạy server Laravel
php artisan serve