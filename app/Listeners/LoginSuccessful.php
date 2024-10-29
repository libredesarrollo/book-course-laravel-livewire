<?php

namespace App\Listeners;

use App\Models\ShoppingCart;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Arr;

class LoginSuccessful
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        $this->setShoppingCartSession();
    }

    private function setShoppingCartSession()
    {
        $cartDB = ShoppingCart::where('user_id', auth()->id())->get();

        $cartSession = session('cart', []);

        foreach ($cartDB as $c) {
            if (Arr::exists($cartSession, $c->post->id)) {
                $cartSession[$c->post->id][1] = $c->count;
            } else {
                $cartSession[$c->post->id] = [$c->post, $c->count];
            }
        }

        session(['cart' => $cartSession]);

    }
}
