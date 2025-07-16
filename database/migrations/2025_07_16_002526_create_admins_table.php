<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // Khóa chính tên 'id' (chuẩn Laravel, BIGINT UNSIGNED AUTO_INCREMENT)

            $table->string('username', 50)->unique(); // Tên đăng nhập, phải duy nhất
            $table->string('password', 255);          // Mật khẩu đã mã hóa (dùng bcrypt hoặc hash)
            $table->string('email', 100)->unique();   // Email quản trị, duy nhất trong hệ thống

            $table->timestamps(); // created_at & updated_at (tự động cập nhật)
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins'); // Xóa bảng nếu rollback
    }
}
