<?php

namespace App\Livewire\Shop;

use App\Models\Post;
use App\Models\ShoppingCart;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use Livewire\Component;

class CartItem extends Component
{


    // protected $listeners = ['addItemToCart' => 'add'];

    public $count; // count
    public $item; // post

    function mount($postId)
    {

        $cart = session('cart', []);

        if (Arr::exists($cart, $postId)) {
            // // // $this->item = $cart[$postId]; // [post, count] // CORREGIR
            // // // $this->count = $this->item[1]; // count
            $this->item = $cart[$postId][0]; // post
            $this->count = $cart[$postId][1]; // count 
        }

        // $post1 = Post::find(12);
        // $post2 = Post::find(20);
        // $post3 = Post::find(28);

        // session(['cart' => [$post1, $post2, $post3]]);
    }

    #[On('addItemToCart')]
    function add(Post $post, int $count = 1)
    {

        // dd($post);
        $cart = session('cart', []);
  
        // delete
        if ($count <= 0) {
            if (Arr::exists($cart, $post->id)) {
                
                unset($cart[$post->id]);
                unset($this->item);
                unset($this->count);
                session(['cart' => $cart]);
                $this->saveDB($cart);
                $this->dispatch('itemDelete');
                
            }
            //  dd($count);
            return;
        }

        //add/update
        if (Arr::exists($cart, $post->id)) {
            $cart[$post->id][1] = $count;
            $this->dispatch('itemChange', $post);
        } else {
            $cart[$post->id] = [$post, $count];
            $this->dispatch('itemAdd', $post);
        }

        $this->item = $post;
        $this->count = $count;

        session(['cart' => $cart]);
        $this->saveDB($cart);

    }
    public function render()
    {
        return view('livewire.shop.cart-item');
    }

    private function saveDB($cart)
    {

        if (auth()->check()) {
            $control = time();
            // dd($cart);
            foreach ($cart as $c) {
                ShoppingCart::updateOrCreate(
                    [
                        'post_id' => $c[0]['id'],
                        'user_id' => auth()->id(),
                    ],
                    [
                        'post_id' => $c[0]['id'],
                        'count' => $c[1],
                        'user_id' => auth()->id(),
                        'control' => $control
                    ]
                );

                // delete
                ShoppingCart::whereNot('control', $control)
                    ->where('user_id', auth()->id())
                    ->delete();

                    
            }

        }
        $this->dispatch('refreshComponent');

    }

}
