<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'count', 'control'];

    function post()
    {
        return $this->belongsTo(Post::class);
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
