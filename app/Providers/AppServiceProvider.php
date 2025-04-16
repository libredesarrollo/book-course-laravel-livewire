<?php

namespace App\Providers;

use App\Models\ShoppingCart;
use Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Event::listen(function (Login $event)  {
        //     $this->setShoppingCartSession();
        // });
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
