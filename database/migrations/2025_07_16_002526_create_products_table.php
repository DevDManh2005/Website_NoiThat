<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Khóa chính mặc định là 'id' (BIGINT UNSIGNED)

            $table->foreignId('category_id')             // Khóa ngoại liên kết đến bảng categories
                  ->constrained('categories')            // Ràng buộc đến bảng 'categories', cột 'id'
                  ->onDelete('cascade');                // Nếu xóa danh mục, xóa luôn sản phẩm

            $table->string('name', 255);                 // Tên sản phẩm
            $table->text('description')->nullable();     // Mô tả sản phẩm

            $table->decimal('price', 10, 2);             // Giá sản phẩm (tối đa 99999999.99)
            $table->integer('stock_quantity')->default(0);          // Số lượng tồn kho

            $table->string('material', 100)->nullable();   // Chất liệu
            $table->string('dimensions', 100)->nullable(); // Kích thước
            $table->decimal('weight', 6, 2)->nullable();   // Trọng lượng, ví dụ 15.75 kg

            $table->string('main_image_url', 255)->nullable(); // URL ảnh chính

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('products'); // Xóa bảng nếu rollback
    }
}
