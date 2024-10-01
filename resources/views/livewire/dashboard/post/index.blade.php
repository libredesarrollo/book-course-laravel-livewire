<div>
    {{-- <style>
        th{
            min-width: 80px !important;
        }
    </style> --}}
    <div class="container">
        <x-action-message on="deleted">
            <div class="box-action-message">
                {{ __('Deleted post success') }}
            </div>
        </x-action-message>


        @slot('header')
            {{ __('CRUD Post') }}
        @endslot

        <x-card>
            @slot('title')
                List
            @endslot

            <a class="btn-secondary mb-3" href="{{ route('d-post-create') }}">Create</a>

            <div class="grid grid-cols-2 gap-2 mb-3">
                <select class="block w-full" wire:model.live='posted'>
                    <option value="">{{ __('Posted') }}</option>
                    <option value="not">{{ __('Not') }}</option>
                    <option value="yes">{{ __('Yes') }}</option>
                </select>
                <select class="block w-full" wire:model.live='type'>
                    <option value="">{{ __('Type') }}</option>
                    <option value="advert">{{ __('Advert') }}</option>
                    <option value="post">{{ __('Post') }}</option>
                    <option value="course">{{ __('Course') }}</option>
                    <option value="movie">{{ __('Movie') }}</option>
                </select>
                <select class="block w-full" wire:model.live='category_id'>
                    <option value="">{{ __('Category') }}</option>
                    @foreach ($categories as $i => $c)
                        <option value="{{ $i }}">{{ $c }}</option>
                    @endforeach
                </select>
                <x-input wire:model.live='search' placeholder="{{ __('Search...') }}" />
                <div class="grid grid-cols-2 gap-2">
                    <x-input wire:model='from' placeholder="From" type='date' />
                    <x-input wire:model.live='to' placeholder="To" type='date' />
                </div>
            </div>

            <table class="table w-full border">
                <thead class="text-left bg-gray-100">
                    <tr class="border-b">
                        @foreach ($columns as $key => $c)
                            <th class="p-2 ">
                                <button wire:click='sort("{{ $key }}")'>
                                    {{ $c }}
                                    @if ($key == $sortColumn)
                                        @if ($sortDirection == 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </button>
                            </th>
                        @endforeach
                        {{-- <th class="p-2">
                            Id
                        </th>
                        <th class="p-2">
                            Title
                        </th>
                        <th class="p-2">
                            Date
                        </th>
                        <th class="p-2">
                            Description
                        </th>
                        <th class="p-2">
                            Posted
                        </th>
                        <th class="p-2">
                            Type
                        </th>
                        <th class="p-2">
                            Category
                        </th> --}}
                        <th class="p-2">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $p)
                        <tr class="border-b">
                            <td class="p-2">
                                {{ $p->id }}
                            </td>
                            <td class="p-2">
                                {{ str($p->title)->substr(0, 15) }}
                            </td>
                            <td class="p-2">
                                {{ $p->date }}
                            </td>
                            <td class="p-2">
                                <textarea>
                                    {{ $p->description }}
                                </textarea>
                            </td>
                            <td class="p-2">
                                {{ $p->type }}
                            </td>
                            <td class="p-2">
                                {{ $p->posted }}
                            </td>
                            <td class="p-2">
                                {{ $p->category->title }}
                            </td>
                            <td class="p-2">
                                <a href="{{ route('d-post-edit', $p) }}">Edit</a>
                                <x-danger-button
                                    wire:click='selectPostToDelete({{ $p }})'>Delete</x-danger-button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </x-card>

        <br>
        {{ $posts->links() }}


        <x-confirmation-modal wire:model='confirmingDeletePost'>
            @slot('title')
                {{ __('Delete Post') }}
            @endslot
            @slot('content')
                {{ __('Are you sure tyou want to delete this post?') }}
            @endslot
            @slot('footer')
                <x-secondary-button wire:click="$toggle('confirmingDeletePost')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-danger-button wire:click="delete()" class="ml-3">
                    {{ __('Delete Post') }}
                </x-danger-button>
            @endslot
        </x-confirmation-modal>

    </div>
</div>
