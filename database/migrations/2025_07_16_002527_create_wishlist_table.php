<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistTable extends Migration

{
    public function up()
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id(); // Tạo khóa chính mặc định 'id' (tự động tăng)

            $table->foreignId('customer_id')              // Khóa ngoại liên kết đến bảng 'customers'
                ->constrained('customers')              // Liên kết đến cột 'id' của 'customers'
                ->onDelete('cascade');                  // Nếu khách bị xóa, xoá wishlist tương ứng

            $table->foreignId('product_id')               // Khóa ngoại liên kết đến bảng 'products'
                ->constrained('products')               // Liên kết đến cột 'id' của 'products'
                ->onDelete('cascade');                  // Nếu sản phẩm bị xóa, xoá wishlist tương ứng
            $table->unique(['customer_id', 'product_id']); // Đảm bảo mỗi khách hàng chỉ có một sản phẩm trong wishlist
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('wishlists'); // Xóa bảng khi rollback
    }
}
