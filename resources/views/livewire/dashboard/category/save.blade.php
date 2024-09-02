<div>

    <div class="container">

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


        <x-form-section submit='submit'>

            <x-slot name="title">
                {{ __('Category') }}
            </x-slot>

            <x-slot name="description">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque hic voluptates quaerat accusantium a. Est
                voluptate voluptatibus necessitatibus a non iure rerum, nesciunt nisi assumenda quaerat nam incidunt ab.
                Facilis.
            </x-slot>

            @slot('form')

                <div class="col-span-10 sm:col-span-3">
                    <x-label for="">Title</x-label>
                    <x-input type="text" wire:model.live='title' class="w-full" />
                    @error('title')
                        {{ $message }}
                    @enderror
                </div>

                <div class="col-span-10 sm:col-span-3">
                    <x-label for="">Text</x-label>
                    <x-input type="text" wire:model='text' class="w-full" />
                    @error('text')
                        {{ $message }}
                    @enderror
                </div>

                <div class="col-span-10 sm:col-span-3">
                    <x-label for="">Image</x-label>
                    <x-input type="file" wire:model='image' class="w-full" />
                    @error('image')
                        {{ $message }}
                    @enderror

                    @if ($category && $category->image)
                        <img class="w-40 my-3" src="{{ $category->getImageUrl() }}" alt="{{ $category->title }}">
                    @endif
                </div>
            @endslot

            @slot('actions')
                <x-button type="submit">Send</x-button>
            @endslot
        </x-form-section>
    </div>
</div>
