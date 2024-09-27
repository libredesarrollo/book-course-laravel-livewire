<?php

namespace App\Livewire\Dashboard\Post;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

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

    function selectPostToDelete(Post $post)
    {
        $this->confirmingDeletePost = true;
        $this->postToDelete = $post;
    }

    public function render()
    {
        // $posts = Post::paginate(15);

        $posts = Post::where('id', '>=', 1);
        // $categories = Category::get();
        $categories = Category::pluck("title", "id");

        //filters
        if ($this->type) {
            $posts->where('type', $this->type);
        }
        if ($this->category_id) {
            $posts->where('category_id', $this->category_id);
        }
        if ($this->posted) {
            $posts->where('posted', $this->posted);
        }
        if ($this->search) {
            $posts->where(function($query){
                $query
                ->orWhere('id', 'like', '%'.$this->search.'%')
                ->orWhere('title', 'like', '%'.$this->search.'%')
                ->orWhere('description', 'like', '%'.$this->search.'%')
                ;
            });
        }

        if ($this->from && $this->to) {
            $posts->whereBetween('date', [date($this->from), date($this->to)]);
        }

        //filters
        $posts = $posts->paginate(15);
        return view('livewire.dashboard.post.index', compact('posts', 'categories'));
    }

    function delete()
    {
        $this->postToDelete->delete();
        $this->confirmingDeletePost = false;
        $this->dispatch('deleted');
    }
}
