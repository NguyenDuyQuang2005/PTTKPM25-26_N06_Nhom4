<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'product_id',
        'content',
        'rating',
        'author_id',
    ];

    // Quan hệ với Product
    public function product()
    {
        return $this->belongsTo(product::class);
    }

    // Quan hệ với User
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
