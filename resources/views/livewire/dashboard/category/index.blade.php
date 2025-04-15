<div>

    <x-action-message on="deleted">
        <div class="box-action-message">
            {{ __("Category delete success") }}
        </div>
    </x-action-message>

    <flux:heading>{{ __('Category List') }}</flux:heading>
    <flux:text class="mt-2">Lorem ipsum dolor sit amet consectetur adipisicing.</flux:text>

    <div class="separation"></div>

    <flux:button class="ml-1 mb-3" variant='primary' icon="plus" href="{{ route('d-category-create') }}">
        {{ __('Create') }}
    </flux:button>

    <!-- <flux:modal.trigger name="delete-category">
       <flux:button>Delete</flux:button>
    </flux:modal.trigger> -->

    <flux:modal name="delete-category">
        <div class="m-1">
            <flux:heading>{{ __('Delete Category') }}</flux:heading>
            <flux:text class="mt-2">{{ __('Are you sure you want to delete this category?') }}</flux:text>

          <div class="flex flex-row-reverse">
            <flux:button class="mt-4" variant='danger' icon="trash" wire:click="delete()">
                {{ __('Delete') }}
            </flux:button>
          </div>
        </div>
    </flux:modal>

    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="table w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="rounded-lg text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th>
                        Id
                    </th>
                    <th>
                        Title
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $c)
                <tr
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <td>
                        {{ $c->id }}
                    </td>
                    <td>
                        {{ $c->title }}
                    </td>
                    <td>
                        <a href="{{ route('d-category-edit', $c) }}">Edit</a>

                        <flux:modal.trigger wire:click="selectCategodyToDelete({{ $c }})" name="delete-category">
                            <flux:button class="ml-3" variant='danger' size="xs">{{ __('Delete') }}</flux:button>
                        </flux:modal.trigger>

                        <!-- <flux:button class="ml-3" variant='danger' size="xs" wire:click="delete({{ $c }})">
                            {{ __('Delete') }}
                        </flux:button> -->
                        {{-- <flux:button class="ml-3" variant='danger' size="xs" wire:click="delete({{ $c }})" wire:confirm="Are you sure you want to delete this category?">
                            {{ __('Delete') }}
                        </flux:button>  --}}
                    </td>
                </tr>
                @endforeach


            </tbody>
        </table>
    </div>
    <br>
    {{ $categories->links() }}
</div>