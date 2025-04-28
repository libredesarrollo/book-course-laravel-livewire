<div class="flex flex-row gap-2">
    @livewire('shop.cart-item', ['postId' => $post->id])
    <flux:button variant='primary' wire:click="dispatch('addItemToCart', { post: {{ $post }} })">Buy</flux:button>
</div>
