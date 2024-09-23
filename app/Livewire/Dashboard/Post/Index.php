<?php

namespace App\Livewire\Dashboard\Post;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{


    use WithPagination;
    public $confirmingDeletePost;
    public $postToDelete;

    function selectPostToDelete(Post $post)
    {
        $this->confirmingDeletePost = true;
        $this->postToDelete = $post;
    }

    public function render()
    {
        $posts = Post::paginate(2);
        return view('livewire.dashboard.post.index', compact('posts'));
    }

    function delete()
    {
        $this->postToDelete->delete();
        $this->confirmingDeletePost = false;
        $this->dispatch('deleted');
    }
}
