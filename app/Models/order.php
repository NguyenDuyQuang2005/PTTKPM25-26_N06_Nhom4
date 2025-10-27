<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'chitiet',
        'trangthai',
        'token',
        'confirmed_at',
        'completed_at',
    ];
    
    protected $dates = [
        'confirmed_at',
        'completed_at',
        'created_at',
        'updated_at',
    ];
}
