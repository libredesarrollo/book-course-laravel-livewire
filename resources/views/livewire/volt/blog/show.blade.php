<?php

use Livewire\Volt\Component;

use App\Models\Post;
use Livewire\Attributes\Layout;

new #[Layout('layouts.web')] class extends Component {
    public $post;
    function mount(Post $post)
    {
        $this->post = $post;
    }
}; ?>

<div>
    <x-card class="mx-auto">
        @slot('title')
            {{ $post->title }}
        @endslot

        <p class="my-4 ml-2">
            <span
                class="text-sm text-gray-500 italic font-bold uppercase tracking-widest">{{ $post->date->format('d-m-Y') }}</span>

            <a class="ml-4 rounded-md bg-purple-500 py-1 px-2 text-white"
                href="{{ route('volt.web.index', ['category_id' => $post->category->id]) }}">
                {{ $post->category->title }}
            </a>

            <a class="ml-4 rounded-md bg-purple-500 py-1 px-2 text-white"
                href="{{ route('volt.web.index', ['type' => $post->type]) }}">
                {{ $post->type }}
            </a>
        </p>

        @if ($post->type == 'advert')
            {{-- @livewire('shop.cart') --}}
            {{-- @livewire('shop.cart', ['post' => $post, 'type' => 'add']) --}}
        @endif

        <div>{!! $post->text !!}</div>

        <hr class="my-8">

        @livewire('contact.general', ['subject' => "#$post->id - "])
    </x-card>
</div>
