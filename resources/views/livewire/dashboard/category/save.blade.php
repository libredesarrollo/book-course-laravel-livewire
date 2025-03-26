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
