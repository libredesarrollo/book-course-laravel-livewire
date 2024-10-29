<div>
    @livewire('shop.cart-item', ['postId' => $post->id])
    {{-- <button class="btn btn-primary" wire:click="addItem()">Buy</button> --}}
    <button class="btn btn-primary" wire:click="dispatch('addItemToCart', { post: {{ $post }} })">Buy</button>
{{--     
NO FUNCIONA
    <button class="btn btn-primary" onclick="add()">Buy</button>
    @script
        <script>
            function add() {
                $wire.dispatch("addItemToCart", '{{ $post }}')
            }
        </script>
    @endscript --}}
    {{ view('livewire.shop.partials.shop-cart', ['total' => $total]) }}
</div>
