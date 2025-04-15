<?php

namespace App\Livewire\Blog;

use App\Models\Category;
use App\Models\Post;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.web')]
class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search;
    #[Url]
    public $type;
    #[Url]
    public $category_id;

    #[Url]
    public $from;
    #[Url]
    public $to;


    public $columns = [
        'id' => "Id",
        'title' => "Title",
        'date' => "Date ",
        'description' => "Description",
        'type' => "Type",
        'category_id' => "Category",
    ];

    public function render()
    {

        $categories = Category::pluck("title", "id");
        $from = $this->from;
      
        $posts = Post::when($this->search, function (Builder $query, string $search) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('id', 'like', "%" . $search . "%")
                    ->orWhere('title', 'like', "%" . $search . "%")
                    ->orWhere('description', 'like', "%" . $search . "%");
            });
        })
        ->when($this->type, function(Builder $query, $type) {
            $query->where('type', $type); 
        })
        ->when($this->category_id, function(Builder $query, $category_id) {
            $query->where('category_id', $category_id); 
        })
       
        ->when($this->to, function(Builder $query, $to) use($from) {
            $query->whereBetween('date', [date($from), date($this->to)]);
        })->with('category')
        ->where('posted','yes')
        ->paginate(15);

        return view('livewire.blog.index', compact('posts', 'categories'));
    }
}
