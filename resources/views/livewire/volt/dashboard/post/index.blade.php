<?php

use Livewire\Volt\Component;

use Livewire\Attributes\Url;
use Livewire\WithPagination;

use Flux\Flux;

use App\Models\Category;
use App\Models\Post;

new class extends Component {
    use WithPagination;

    public $postToDelete;

    public function with()
    {
        $posts = Post::paginate(15);
        return ['posts' => $posts];
    }

    function selectPostToDelete(Post $post)
    {
        $this->postToDelete = $post;
    }

    function delete()
    {
        $this->dispatch('deleted');
        Flux::modal('delete-post')->close();

        $this->postToDelete->delete();
    }
}; ?>

<div>
    <x-action-message on="deleted">
        <div class="box-action-message">
            {{ __('Posts delete success') }}
        </div>
    </x-action-message>

    <flux:heading>{{ __('Posts List') }}</flux:heading>
    <flux:text class="mt-2">Lorem ipsum dolor sit amet consectetur adipisicing.</flux:text>

    <div class="separation"></div>

    <flux:button class="ml-1 mb-3" variant='primary' icon="plus" href="{{ route('volt-d-post-create') }}">
        {{ __('Create') }}
    </flux:button>

    <flux:modal name="delete-post">
        <div class="m-1">
            <flux:heading>{{ __('Delete Post') }}</flux:heading>
            <flux:text class="mt-2">{{ __('Are you sure you want to delete this post?') }}</flux:text>

            <div class="flex flex-row-reverse">
                <flux:button class="mt-4" variant='danger' icon="trash" wire:click="delete()">
                    {{ __('Delete') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>



    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="table w-full border">
            <thead class="rounded-lg text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>

                    <th class="p-2">
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
                    </th>
                    <th class="p-2">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $p)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <td>
                            {{ $p->id }}
                        </td>
                        <td>
                            {{ str($p->title)->substr(0, 15) }}
                        </td>
                        <td>
                            {{ $p->date }}
                        </td>
                        <td>
                            <textarea>
                                    {{ $p->description }}
                                </textarea>
                        </td>
                        <td>
                            {{ $p->type }}
                        </td>
                        <td>
                            {{ $p->posted }}
                        </td>
                        <td>
                            {{ $p->category->title }}
                        </td>
                        <td>
                            <a href="{{ route('volt-d-post-edit', $p) }}">Edit</a>

                            <flux:modal.trigger wire:click="selectPostToDelete({{ $p }})"
                                name="delete-post">
                                <flux:button class="ml-3" variant='danger' size="xs">{{ __('Delete') }}
                                </flux:button>
                            </flux:modal.trigger>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <br>
    {{ $posts->links() }}




</div>
