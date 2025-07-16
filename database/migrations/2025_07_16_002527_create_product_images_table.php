<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id(); // Tạo khóa chính mặc định tên 'id' (tự động tăng)

            $table->foreignId('product_id')              // Tạo khóa ngoại liên kết đến bảng 'products'
                  ->constrained('products')              // Mặc định liên kết đến cột 'id' của bảng 'products'
                  ->onDelete('cascade');                 // Khi sản phẩm bị xóa, ảnh liên quan cũng bị xóa

            $table->string('image_url', 255);            // Đường dẫn ảnh phụ

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_images'); // Xóa bảng nếu rollback
    }
}
