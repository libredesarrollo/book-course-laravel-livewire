<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'image', 'text'];

    function posts()  {
        return $this->hasMany(Post::class);
    }

    function getImageUrl(){
        return URL::asset("images/category/".$this->image);
    }
}
