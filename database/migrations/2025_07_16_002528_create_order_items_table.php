<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // Khóa chính mặc định tên 'id' theo chuẩn Laravel

            $table->foreignId('order_id')                 // Khóa ngoại trỏ đến bảng orders
                  ->constrained('orders')                 // Liên kết đến cột 'id' của bảng 'orders'
                  ->onDelete('cascade');                 // Nếu đơn hàng bị xóa, các mục sẽ bị xóa theo

            $table->foreignId('product_id')               // Khóa ngoại trỏ đến bảng products
                  ->constrained('products')               // Liên kết đến cột 'id' của bảng 'products'
                  ->onDelete('cascade');                 // Nếu sản phẩm bị xóa, mục tương ứng bị xóa

            $table->integer('quantity');                 // Số lượng sản phẩm trong đơn hàng

            $table->decimal('unit_price', 10, 2);        // Đơn giá tại thời điểm mua

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items'); // Xóa bảng nếu rollback
    }
}
