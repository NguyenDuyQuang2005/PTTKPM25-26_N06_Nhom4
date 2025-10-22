<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    // Quan hệ với Comment
    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }
}
