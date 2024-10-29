
    {{-- @foreach (session('cart') as $c)
        <div class="box mb-3">
            <p>
                <input class="w-20" type="number">
                {{ $c->title }}
            </p>
        </div>
    @endforeach --}}


<div>
    <h3 class="text-center text-3xl mb-4">Shopping cart</h3>
    @foreach ($cart as $c)
        @livewire('shop.cart-item', ['postId' => $c[0]['id']])
    @endforeach

    {{ view('livewire.shop.partials.shop-cart', ['total' => $total]) }}
</div>

