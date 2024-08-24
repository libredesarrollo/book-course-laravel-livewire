<div>

    <x-action-message on="created">
        {{ __('Created category success') }}
    </x-action-message>

    <x-action-message on="updated">
        {{ __('Updated category success') }}
    </x-action-message>

    <form wire:submit.prevent='submit'>

        <label for="">Title</label>
        <input type="text" wire:model.live='title'>
        @error('title')
            {{ $message }}
        @enderror

        <label for="">Text</label>
        <input type="text" wire:model='text'>
        @error('text')
            {{ $message }}
        @enderror

        <label for="">Image</label>
        <input type="file" wire:model='image'>
        @error('image')
            {{ $message }}
        @enderror

        @if ($category && $category->image)
            <img class="w-40 my-3" src="{{ $category->getImageUrl() }}" alt="{{ $category->title }}">
        @endif

        <button type="submit">Send</button>
    </form>
</div>
