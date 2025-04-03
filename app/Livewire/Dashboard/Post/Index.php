<?php

namespace App\Livewire\Dashboard\Post;

use App\Livewire\Dashboard\OrderTrait;
use App\Models\Category;
use App\Models\Post;
use Flux\Flux;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
   

    public function render()
    {


        $posts = Post::paginate(15);

        return view('livewire.dashboard.post.index', compact('posts'));
    }
       
    
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

    function selectPostToDelete(Post $post)
    {
        $this->postToDelete = $post;
    }


    function delete()
    {
        $this->dispatch("deleted");
        Flux::modal("delete-post")->close();
        
        $this->postToDelete->delete();
    }
}
