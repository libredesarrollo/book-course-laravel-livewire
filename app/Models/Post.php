<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'image', 'text', 'description', 'date', 'type', 'category_id', 'posted'];

    // protected $casts = [
    //     'date' => 'datetime'
    // ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime'
        ];
    }

    function category()
    {
        return $this->belongsTo(Category::class);
    }

    function tags()
    {
        return $this->morphedByMany(Tag::class, 'taggables');
    }

    function getImageURL()
    {
     if($this->image == '' ){
        return URL::asset("images/default.jpg");
     }
        return URL::asset("images/post/" . $this->image);
    }
}
