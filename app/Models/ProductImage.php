<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images'; // rõ ràng tên bảng nếu cần

    protected $fillable = [
        'product_id',
        'image_url',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ✅ Nếu bạn cần phân biệt ảnh URL và ảnh upload
    public function isUploaded()
    {
        return str_starts_with($this->image_url, 'storage/');
    }
}
