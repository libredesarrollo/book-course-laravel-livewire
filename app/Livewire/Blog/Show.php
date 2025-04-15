<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.web')]
class Show extends Component
{
    public $post;
    function mount(Post $post)
    {
        $this->post = $post;
    }
    public function render()
    {
        return view('livewire.blog.show');
    }
}
