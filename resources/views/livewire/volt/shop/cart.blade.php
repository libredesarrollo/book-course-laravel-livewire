<?php

use Livewire\Volt\Component;

use Livewire\Attributes\Layout;

use App\Models\Post;
use App\Models\ShoppingCart;

new 
#[Layout('layouts.web')]
class extends Component {
    public $type = 'list';
    public $post;
    public $cart;
    public $total;

    protected $listeners = ['itemDelete' => 'getTotal', 'itemAdd' => 'getTotal', 'itemChange' => 'getTotal'];

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
    }

    // public function render()
    // {
    //     $this->getTotal();
    //     if ($this->type == 'list') {
    //         return view('livewire.shop.cart');
    //     }
    //     return view('livewire.shop.cart-add');
    // }
}; ?>

<div>
    @if ($type == 'list')
        <div>
            <h3 class="text-center text-3xl mb-4">Shopping cart</h3>
            @foreach ($cart as $c)
                @livewire('shop.cart-item', ['postId' => $c[0]['id']])
            @endforeach

            {{ view('livewire.shop.partials.shop-cart', ['total' => $total]) }}
        </div>
    @else
        <div class="flex flex-row gap-2">
            @livewire('shop.cart-item', ['postId' => $post->id])
            <flux:button variant='primary' wire:click="dispatch('addItemToCart', { post: {{ $post }} })">Buy
            </flux:button>
        </div>
    @endif
</div>
