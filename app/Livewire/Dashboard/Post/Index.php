<?php

namespace App\Livewire\Dashboard\Post;

use App\Livewire\Dashboard\OrderTrait;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    use OrderTrait;

    #[Url]
    public $search;
    #[Url]
    public $type;
    #[Url]
    public $category_id;
    // #[Url('q')]
    #[Url]
    public $posted;
    #[Url]
    public $from;
    #[Url]
    public $to;

    public $confirmingDeletePost;
    public $postToDelete;


    public $columns = [
        'id' => "Id",
        'title' => "Title",
        'date' => "Date ",
        'description' => "Description",
        'posted' => "Posted",
        'type' => "Type",
        'category_id' => "Category",
    ];

    function selectPostToDelete(Post $post)
    {
        $this->confirmingDeletePost = true;
        $this->postToDelete = $post;
    }

    public function render()
    {
        // $posts = Post::paginate(15);

        // $posts = Post::where('id', '>=', 1);
      
        // $categories = Category::get();
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
        ->when($this->posted, function(Builder $query, $posted) {
            $query->where('posted', $posted); 
        })
        ->when($this->type, function(Builder $query, $type) {
            $query->where('type', $type); 
        })
        ->when($this->to, function(Builder $query, $to) use($from) {
            $query->whereBetween('date', [date($from), date($this->to)]);
        })->with('category')
        ->orderBy($this->sortColumn, $this->sortDirection)
        ->paginate(15);

        return view('livewire.dashboard.post.index', compact('posts', 'categories'));
    }
    // public function render()
    // {
    //     // $posts = Post::paginate(15);

    //     // $posts = Post::where('id', '>=', 1);
    //     $posts = new Post();
    //     // $categories = Category::get();
    //     $categories = Category::pluck("title", "id");
       
    //     //filters
    //     if ($this->type) {
    //         $posts = $posts->where('type', $this->type);
    //     }
    //     if ($this->category_id) {
    //         $posts = $posts->where('category_id', $this->category_id);
    //     }
    //     if ($this->posted) {
    //         $posts = $posts->where('posted', $this->posted);
    //     }
    //     if ($this->search) {
    //         $posts = $posts->where(function($query){
    //             $query
    //             ->orWhere('id', 'like', '%'.$this->search.'%')
    //             ->orWhere('title', 'like', '%'.$this->search.'%')
    //             ->orWhere('description', 'like', '%'.$this->search.'%')
    //             ;
    //         });
    //     }

    //     if ($this->from && $this->to) {
    //         $posts = $posts->whereBetween('date', [date($this->from), date($this->to)]);
    //     }

    //     //filters
    //     $posts = $posts->paginate(15);
    //     return view('livewire.dashboard.post.index', compact('posts', 'categories'));
    // }


    function delete()
    {
        $this->postToDelete->delete();
        $this->confirmingDeletePost = false;
        $this->dispatch('deleted');
    }
}
