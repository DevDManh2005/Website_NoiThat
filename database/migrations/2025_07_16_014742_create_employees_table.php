<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Khóa chính mặc định là 'id'

            $table->string('first_name', 50);               // Tên nhân viên
            $table->string('last_name', 50);                // Họ nhân viên
            $table->string('email', 100)->unique();         // Email duy nhất
            $table->string('phone', 20)->nullable();        // Số điện thoại (có thể rỗng)
            $table->string('role', 50);                     // Vai trò (bán hàng, kho, ...)

            $table->date('hire_date')->nullable();          // Ngày tuyển dụng
            $table->decimal('salary', 10, 2)->nullable();   // Lương

            $table->string('status', 20)->default('active'); // Trạng thái (active/inactive)

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees'); // Xóa bảng nếu rollback
    }
}
