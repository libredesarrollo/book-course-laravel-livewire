<div>
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

            <table class="table w-full border">
                <thead class="text-left bg-gray-100">
                    <tr class="border-b">
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
                        </th>
                        <th class="p-2">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $p)
                        <tr class="border-b">
                            <td class="p-2">
                                {{ $p->title }}
                            </td>
                            <td class="p-2">
                                {{ $p->date }}
                            </td>
                            <td class="p-2">
                                {{ $p->description }}
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
               {{  __('Are you sure tyou want to delete this post?') }}
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
