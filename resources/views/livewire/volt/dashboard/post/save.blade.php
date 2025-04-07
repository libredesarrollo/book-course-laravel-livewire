<?php

use Livewire\Volt\Component;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;

use App\Models\Category;
use App\Models\Post;

new class extends Component {
    #[Validate('required', as: 'postsito')]
    public $title;

    public $description;
    public $text;
    public $type;
    public $posted;
    public $category_id;
    public $image;
    public $date;

    public $post;

    #[Locked]
    public $id;

    public $categories;

    protected $rules = [
        // 'title' => 'required|min:2|max:255',
        'description' => 'required|min:2|max:255',
        'date' => 'required',
        'category_id' => 'required',
        'posted' => 'required',
        'text' => 'required|min:2|max:5000',
        'image' => 'nullable|image|max:1024'
    ];

    function mount(?int $id = null)
    {
        if ($id != null) {
            $this->id = $id;
            $this->post = Post::findOrFail($id);
            $this->title = $this->post->title;
            $this->text = $this->post->text;
            $this->category_id = $this->post->category_id;
            $this->posted = $this->post->posted;
            $this->type = $this->post->type;
            $this->description = $this->post->description;
            $this->date = $this->post->date;
        }

        $this->categories = Category::get();
    }

    function submit(/*$content*/)
    {
        // dd($content);
        $this->validate();
        // dd($this->id);
        if ($this->post) {
            $this->post->update(
                [
                    'title' => $this->title,
                    'text' => $this->text,
                    'description' => $this->description,
                    'category_id' => $this->category_id,
                    'date' => $this->date,
                    'type' => $this->type,
                    'posted' => $this->posted,
                    'slug' => str($this->title)->slug(),
                ]
            );
            $this->dispatch('updated');
        } else {
            $this->post = Post::create(
                [
                    'title' => $this->title,
                    'text' => $this->text,
                    'description' => $this->description,
                    'category_id' => $this->category_id,
                    'date' => $this->date,
                    'type' => $this->type,
                    'posted' => $this->posted,
                    'slug' => str($this->title)->slug(),
                ]
            );
            $this->dispatch('created');
        }

        // upload
        if ($this->image) {
            $imageName = $this->post->slug . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('images/post', $imageName, 'public_upload');

            $this->post->update([
                'image' => $imageName
            ]);
        }
    }
}; ?>

<div>

    <div class="container">

        <x-action-message on="created">
            <div class="box-action-message">
                {{ __('Created post success') }}
            </div>
        </x-action-message>

        <x-action-message on="updated">
            <div class="box-action-message">
                {{ __('Updated post success') }}
            </div>
        </x-action-message>

        <flux:heading>

            @if ($post)
                {{ __('Post edit: ') }} <span class="font-bold">{{ $post->title }}</span>
            @else
                {{ __('Post create') }}
            @endif
        </flux:heading>
        <flux:text class="mt-2">Lorem ipsum dolor sit amet consectetur adipisicing.</flux:text>

        <div class="separation"></div>

        <form wire:submit.prevent="submit" class="flex flex-col gap-4">

            {{ $title }}
            <flux:input wire:model.blur="title" :label="__('Title')" />
            <flux:input wire:model="date" :label="__('Date')" type="date" />
            <flux:textarea wire:model="description" :label="__('Description')" />

            <flux:textarea wire:model="text" :label="__('Text')" />


            <flux:label>{{ __('Posted') }}</flux:label>
            <flux:select wire:model='posted'>
                <option value=""></option>
                <option value="yes">Yes</option>
                <option value="not">Not</option>
            </flux:select>


            <flux:label>{{ __('Type') }}</flux:label>
            <flux:select wire:model='type'>
                <option value=""></option>
                <option value="advert">Advert</option>
                <option value="post">Post</option>
                <option value="course">Course</option>
                <option value="movie">Movie</option>
            </flux:select>

            <flux:label>{{ __('Category') }}</flux:label>
            <flux:select wire:model='category_id'>
                <option value=""></option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->title }}</option>
                @endforeach
            </flux:select>

            <flux:input wire:model="image" type='file' :label="__('Image')" />

            @if ($post && $post->image)
                <img class="w-40 my-3" src="{{ $post->getImageUrl() }}" alt="{{ $post->title }}">
            @endif

            <div>
                <flux:button variant="primary" type="submit">
                    {{ __('Save') }}
                </flux:button>
            </div>

        </form>


    </div>
</div>
