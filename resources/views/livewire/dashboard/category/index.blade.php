<div>
    <div class="container">
        <x-action-message on="deleted">
            <div class="box-action-message">
                {{ __('Deleted category success') }}
            </div>
        </x-action-message>


        @slot('header')
            {{ __('CRUD Category') }}
        @endslot

        <x-card>
            @slot('title')
                List
            @endslot

            <a class="btn-secondary mb-3" href="{{ route('d-category-create') }}">Create</a>

            <table class="table w-full border">
                <thead class="text-left bg-gray-100">
                    <tr class="border-b">
                        <th class="p-2">
                            Title
                        </th>
                        <th class="p-2">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $c)
                        <tr class="border-b">
                            <td class="p-2">
                                {{ $c->title }}
                            </td>
                            <td class="p-2">
                                <a href="{{ route('d-category-edit', $c) }}">Edit</a>
                                <x-danger-button
                                    wire:click='selectCategoryToDelete({{ $c }})'>Delete</x-danger-button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </x-card>

        <br>
        {{ $categories->links() }}


        <x-confirmation-modal wire:model='confirmingDeleteCategory'>
            @slot('title')
                {{ __('Delete Category') }}
            @endslot
            @slot('content')
               {{  __('Are you sure tyou want to delete this category?') }}
            @endslot
            @slot('footer')
                <x-secondary-button wire:click="$toggle('confirmingDeleteCategory')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-danger-button wire:click="delete()" class="ml-3">
                    {{ __('Delete Category') }}
                </x-danger-button>
            @endslot
        </x-confirmation-modal>

    </div>
</div>
