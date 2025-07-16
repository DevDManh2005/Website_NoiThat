<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Tạo khóa chính, mặc định là 'id' (BIGINT UNSIGNED AUTO_INCREMENT)

            $table->string('name', 100); // Tên danh mục, độ dài tối đa 100 ký tự
            $table->text('description')->nullable(); // Mô tả danh mục (có thể để trống)

            $table->foreignId('parent_id')              // ID của danh mục cha (nếu có)
                  ->nullable()                          // Cho phép null nếu không có cha
                  ->constrained('categories', 'id')     // Ràng buộc tự liên kết với chính bảng 'categories'
                  ->onDelete('set null');               // Nếu danh mục cha bị xóa, set null danh mục con

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories'); // Xóa bảng nếu rollback
    }
}
