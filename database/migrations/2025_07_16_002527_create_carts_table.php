<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // Tạo khóa chính tên 'id' theo chuẩn Laravel

            $table->foreignId('customer_id')              // Tạo khóa ngoại liên kết đến bảng 'customers'
                  ->constrained('customers')              // Mặc định liên kết đến cột 'id' của bảng 'customers'
                  ->onDelete('cascade');                 // Khi khách hàng bị xóa, giỏ hàng sẽ tự động bị xóa theo

            $table->timestamps(); // Tạo cột 'created_at' và 'updated_at'
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts'); // Xóa bảng nếu rollback migration
    }
}
