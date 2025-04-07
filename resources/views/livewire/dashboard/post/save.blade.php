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

            <flux:input wire:model="form.title" :label="__('Title')" />
            <flux:input wire:model="form.date" :label="__('Date')" type="date" />
            <flux:textarea wire:model="form.description" :label="__('Description')" />

            <flux:textarea wire:model="form.text" :label="__('Text')" />


            <flux:label>{{ __('Posted') }}</flux:label>
            <flux:select wire:model='form.posted'>
                <option value=""></option>
                <option value="yes">Yes</option>
                <option value="not">Not</option>
            </flux:select>


            <flux:label>{{ __('Type') }}</flux:label>
            <flux:select wire:model='form.type'>
                <option value=""></option>
                <option value="advert">Advert</option>
                <option value="post">Post</option>
                <option value="course">Course</option>
                <option value="movie">Movie</option>
            </flux:select>

            <flux:label>{{ __('Category') }}</flux:label>
            <flux:select wire:model='form.category_id'>
                <option value=""></option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->title }}</option>
                @endforeach
            </flux:select>

            <flux:input wire:model="form.image" type='file' :label="__('Image')" />

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
