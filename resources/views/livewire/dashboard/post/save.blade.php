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


        {{-- <x-form-section submit='submit(editor.getData())'> --}}
        <x-form-section submit='submit'>

            <x-slot name="title">
                {{ __('Post') }}
            </x-slot>

            <x-slot name="description">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque hic voluptates quaerat accusantium a. Est
                voluptate voluptatibus necessitatibus a non iure rerum, nesciunt nisi assumenda quaerat nam incidunt ab.
                Facilis.
            </x-slot>

            @slot('form')

                <div class="col-span-10 sm:col-span-3">
                    <x-label for="">Title</x-label>
                    <x-input type="text" wire:model='title' class="w-full" />
                    @error('title')
                        {{ $message }}
                    @enderror
                </div>

                <div class="col-span-10 sm:col-span-3">
                    <x-label for="">Date</x-label>
                    <x-input type="date" wire:model='date' class="w-full" />
                    @error('date')
                        {{ $message }}
                    @enderror
                </div>

                <div class="col-span-10 sm:col-span-3">
                    <x-label for="">Description</x-label>
                    <textarea wire:model='description' class="block w-full"></textarea>
                    @error('description')
                        {{ $message }}
                    @enderror
                </div>

                <div class="col-span-10 sm:col-span-6" wire:ignore>
                    <x-label for="">Text</x-label>
                    {{-- <div id="ckcontent">{!! $text !!}</div> --}}
                    <textarea id="ckcontent">{!! $text !!}</textarea>
                    <textarea wire:model='text' class="block w-full hidden"></textarea>
                    @error('description')
                        {{ $message }}
                    @enderror
                </div>

                <div class="col-span-10 sm:col-span-3">
                    <x-label for="">Posted</x-label>
                    <select class="block w-full" wire:model='posted'>
                        <option value=""></option>
                        <option value="yes">Yes</option>
                        <option value="not">Not</option>
                    </select>
                    @error('posted')
                        {{ $message }}
                    @enderror
                </div>

                <div class="col-span-10 sm:col-span-3">
                    <x-label for="">Type</x-label>
                    <select class="block w-full" wire:model='type'>
                        <option value=""></option>
                        <option value="Advert">Advert</option>
                        <option value="post">Post</option>
                        <option value="course">Course</option>
                        <option value="movie">Movie</option>
                    </select>
                    @error('type')
                        {{ $message }}
                    @enderror
                </div>

                <div class="col-span-10 sm:col-span-3">
                    <x-label for="">Category</x-label>
                    <select class="block w-full" wire:model='category_id'>
                        <option value=""></option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->title }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        {{ $message }}
                    @enderror
                </div>


                <div class="col-span-10 sm:col-span-3">
                    <x-label for="">Image</x-label>
                    <x-input type="file" wire:model='image' class="w-full" />
                    @error('image')
                        {{ $message }}
                    @enderror

                    @if ($post && $post->image)
                        <img class="w-40 my-3" src="{{ $post->getImageUrl() }}" alt="{{ $post->title }}">
                    @endif
                </div>
            @endslot

            @slot('actions')
                <x-button type="submit">Send</x-button>
            @endslot
        </x-form-section>

        @vite(['resources/js/ckeditor.js'])

    </div>
</div>

@script
<script>
    editor.model.document.on('change:data', () => {
        $wire.text = editor.getData()
	})
</script>
@endscript
