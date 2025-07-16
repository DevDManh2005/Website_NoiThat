<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Khóa chính mặc định là 'id' (BIGINT UNSIGNED AUTO_INCREMENT)

            $table->string('first_name', 50);   // Tên khách hàng
            $table->string('last_name', 50);    // Họ khách hàng
            $table->string('email', 100)->unique(); // Email duy nhất
            $table->string('password', 255);    // Mật khẩu mã hóa (dùng bcrypt/hash)

            $table->string('phone', 20)->nullable(); // Số điện thoại (không bắt buộc)
            $table->text('address')->nullable();     // Địa chỉ chi tiết (nullable)

            $table->string('city', 100)->nullable();     // Thành phố (nullable)
            $table->string('district', 100)->nullable(); // Quận/huyện (nullable)
            $table->string('ward', 100)->nullable();     // Phường/xã (nullable)

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();    

            $table->timestamps(); // created_at & updated_at (tự động cập nhật)
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers'); // Xóa bảng nếu rollback
    }
}
