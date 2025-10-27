<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = [
        'name',
        'masanpham',
        'price_normal',
        'price_sale',
        'description',
        'content',
        'image',
        'images',
    ];

    // Quan hệ với Comment
    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }
}
