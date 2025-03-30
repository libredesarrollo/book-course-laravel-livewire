<?php

use Livewire\Volt\Component;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use App\Models\Category;

new class extends Component {

    use WithFileUploads;

    public $title;
    public $slug;
    public $text;
    public $image;

    protected $rules = [
        'title' => "required|min:2|max:255",
        'text' => "nullable",
        'image' => "nullable|image|max:1024",
    ];

    public $category;

    public function mount(?int $id = null)
    {
        if ($id != null) {
            $this->category = Category::findOrFail($id);
            $this->title = $this->category->title;
            $this->text = $this->category->text;
        }
    }

    function submit()
    {
        // validate
        $this->validate();

        if ($this->category) {
            $this->category->update([
                'title' => $this->title,
                'text' => $this->text,
            ]);
            $this->dispatch("updated");
        } else {

            $this->category = Category::create([
                'title' => $this->title,
                'slug' => str($this->title)->slug(),
                'text' => $this->text,
            ]);
            $this->dispatch("created");
        }

        // upload
        if ($this->image) {
            // delete old img
            if ($this->category->image) {
                Storage::disk('public_upload')
                    ->delete('images/category/' . $this->category->image);
            }


            $imageName = $this->category->slug . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('images/category', $imageName, 'public_upload');


            $this->category->update([
                'image' => $imageName
            ]);
        }
    }

}; ?>

<div>

    <x-action-message on="created">
        <div class="box-action-message">
            {{ __('Created category success') }}
        </div>

    </x-action-message>

    <x-action-message on="updated">
        <div class="box-action-message">
            {{ __('Updated category success') }}
        </div>
    </x-action-message>

    <flux:heading>

        @if ($category)
            {{ __('Category edit: ') }} <span class="font-bold">{{ $category->title }}</span>
        @else
            {{ __('Category create') }}
        @endif
    </flux:heading>
    <flux:text class="mt-2">Lorem ipsum dolor sit amet consectetur adipisicing.</flux:text>

    <div class="separation"></div>

    <form wire:submit.prevent="submit" class="flex flex-col gap-4">
        <!-- <input type="text" wire:model="title">
        <textarea wire:model="text"></textarea>
        <button type="submit" wire:click="submit">Send</button> -->

        {{-- <input type="text" wire:model="title"> --}}

        {{-- @error('title')
        {{ $message }}
        @enderror --}}

        <flux:input wire:model="title" :label="__('Title')" />

        <flux:textarea wire:model="text" :label="__('Text')" />

        <flux:input wire:model="image" type='file' :label="__('Image')" />

        {{-- @error('text')
        {{ $message }}
        @enderror --}}

        <div>
            <flux:button variant="primary" type="submit">
                {{ __('Save') }}
            </flux:button>
        </div>
    </form>

    @if ($category && $category->image)
        <img class="w-40 my-3" src="{{ $category->getImageUrl() }}" />
    @endif

</div>
