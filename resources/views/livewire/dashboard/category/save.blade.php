<div>

    <x-action-message on="created">
        {{ __('Created category success') }}
    </x-action-message>


    <x-action-message on="updated">
        {{ __('Updated category success') }}
    </x-action-message>


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
