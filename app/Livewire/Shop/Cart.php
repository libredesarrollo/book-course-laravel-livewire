<?php

namespace App\Livewire\Shop;

use App\Models\Post;
use App\Models\ShoppingCart;
use Livewire\Attributes\Computed;
use Livewire\Component;

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
    }

   public function getTotal()
    {
        if (auth()->check()) {
            $this->total = ShoppingCart::where('user_id', auth()->id())->sum('count');
        }
        // TODO read sesion
    }

    public function render()
    {
        $this->getTotal();
        if ($this->type == 'list')
            return view('livewire.shop.cart');
        return view('livewire.shop.cart-add');
    }
}
