<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Post;
use App\Models\ShoppingCart;

#[Layout('layouts.web')]
class Cart extends Component
{

    public $type = 'list';
    public $post;
    public $cart;
    public $total;
    

    protected $listeners = ['itemDelete' => 'getTotal', 'itemAdd' => 'getTotal', 'itemChange' => 'getTotal'];

    // private function initSessionCart(Post $post, $type = 'list')
    // {
    //     $this->cart = session('cart', []);
    //     $this->type = $type;
    //     $this->post = $post;
    //     dd($this->cart );

    //     // $post1 = Post::find(12);
    //     // $post2 = Post::find(20);
    //     // $post3 = Post::find(28);


    //     // session(['cart' => [$post1, $post2, $post3]]);

    // }

    function mount(Post $post, $type = 'list')
    {
        // $this->initSessionCart();
        // session(['cart' => []]); // set/delete cart
        $this->type = $type;
        $this->post = $post;

        $this->cart = session('cart', []);
        // dd($this->cart );
    }

    function addItem()
    {
        $this->dispatch('addItemToCart', $this->post);
        // $this->dispatch('cartUpdated');
    }

   public function getTotal()
    {
        if (auth()->check()) {
            $this->total = ShoppingCart::where('user_id', auth()->id())->sum('count');
        }
        // 
    }

    public function render()
    {
        $this->getTotal();
        if ($this->type == 'list')
            return view('livewire.shop.cart');
        return view('livewire.shop.cart-add');
    }
}
