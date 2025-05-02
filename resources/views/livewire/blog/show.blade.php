<div>
    <x-card class="mx-auto">
        @slot('title')
            {{ $post->title }}
        @endslot

        <p class="my-4 ml-2">
            <span
                class="text-sm text-gray-500 italic font-bold uppercase tracking-widest">{{ $post->date->format('d-m-Y') }}</span>

            <a class="ml-4 rounded-md bg-purple-500 py-1 px-2 text-white"
                href="{{ route('web.index', ['category_id' => $post->category->id]) }}">
                {{ $post->category->title }}
            </a>

            <a class="ml-4 rounded-md bg-purple-500 py-1 px-2 text-white"
                href="{{ route('web.index', ['type' => $post->type]) }}">
                {{ $post->type }}
            </a>
        </p>


        @if ($post->type == 'advert')
            <div class="mycard mb-5 ms-auto block max-w-96">
                <div class="mycard-body">
                    @livewire('shop.cart', key($key))
                    @livewire('volt.shop.cart', key($key))
                </div>
            </div>
            {{-- @if ($isCartAddItemVisible) --}}
            {{-- si el item esta en el carrito, removemos la opcion de agregar --}}
            <div style="display: none;" class="overflow-auto mycard-primary mb-5 block max-w-96" x-data="{ visible: @entangle('isCartAddItemVisible') }"
                x-show="visible" 
                {{-- al aparecer el div, se hace un efecto de entrada --}} 
                x-transition:enter="transition transform ease-out duration-800"
                x-transition:enter-start="opacity-0 translate-y-5 h-0"
                x-transition:enter-end="opacity-100 translate-y-0 h-auto" 
                {{-- al deaparecer el div, se hace un efecto de entrada --}}
                x-transition:leave="transition transform ease-in duration-900"
                x-transition:leave-start="opacity-100 translate-y-0 h-auto"
                x-transition:leave-end="opacity-0 -translate-y-5 xh-5">
                <div class="mycard-body">
                    <h3 class="text-center text-3xl mb-4">Add this item</h3>
                    @livewire('shop.cart', ['post' => $post, 'type' => 'add'])
                    @livewire('volt.shop.cart', ['post' => $post, 'type' => 'add'])
                </div>
            </div>
            {{-- @endif --}}
        @endif

        <div>{!! $post->text !!}</div>

        <hr class="my-8">

        @livewire('contact.general', ['subject' => "#$post->id - "])
    </x-card>
    <style>
        .item_{{ $post->id }} ui-label {
            color: red !important;
        }
    </style>
</div>
