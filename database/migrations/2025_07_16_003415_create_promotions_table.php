<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id(); // Khóa chính mặc định 'id' theo chuẩn Laravel

            $table->string('code', 50)->unique(); // Mã giảm giá, duy nhất

            $table->enum('type', ['percent', 'fixed'])->default('percent'); // Phân biệt phần trăm và cố định

            $table->text('description')->nullable(); // Mô tả mã khuyến mãi

            $table->decimal('discount_percentage', 5, 2); // Ví dụ: 10.00 = 10%

            $table->dateTime('start_date');
            
            $table->dateTime('end_date');


            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions'); // Xóa bảng nếu rollback
    }
}
