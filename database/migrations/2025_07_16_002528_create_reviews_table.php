<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Khóa chính mặc định là 'id' theo chuẩn Laravel

            $table->foreignId('product_id')                  // Khóa ngoại tới bảng 'products'
                ->constrained('products')
                ->onDelete('cascade');                    // Nếu xóa sản phẩm thì xóa luôn đánh giá

            $table->foreignId('customer_id')                 // Khóa ngoại tới bảng 'customers'
                ->constrained('customers')
                ->onDelete('cascade');                    // Nếu xóa khách hàng thì xóa luôn đánh giá

            $table->unsignedTinyInteger('rating')->check('rating BETWEEN 1 AND 5');        // Số sao đánh giá (1-5). Có thể thêm kiểm tra trong form request

            $table->text('comment')->nullable();            // Nội dung bình luận, có thể bỏ trống

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews'); // Xóa bảng nếu rollback
    }
}
