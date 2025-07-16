<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'code', 'type', 'description',
        'discount_percentage', 'start_date', 'end_date'
    ];
}
