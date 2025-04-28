<?php

namespace App\Livewire\Blog;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Post;

#[Layout('layouts.web')]
class Show extends Component
{

    // protected $listeners = ['cartUpdated' => '$refresh'];

    public $post;
    public $key = 1;
    public $isCartAddItemVisible;

    function mount(Post $post)
    {
        $this->isCartAddItemVisible = !isset(session('cart')[$post->id]);
        // dd($this->isCartAddItemVisible);
        $this->post = $post;
    }
    public function render()
    {
        return view('livewire.blog.show');
    }

    #[On('refreshComponent')]
    function refreshComponent()
    {
        // sleep(1);
        $this->key = date('Y-m-d H:i:s');
        $this->isCartAddItemVisible = !isset(session('cart')[$this->post->id]);
        // $refresh = true;
    }
}
