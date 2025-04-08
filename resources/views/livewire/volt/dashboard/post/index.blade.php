<?php

use Livewire\Volt\Component;

use Illuminate\Contracts\Database\Eloquent\Builder;

use Livewire\Attributes\Url;
use Livewire\WithPagination;

use Flux\Flux;

use App\Models\Category;
use App\Models\Post;
use App\Livewire\Dashboard\OrderTrait;

new class extends Component {
    use WithPagination;

    use OrderTrait;

    #[Url]
    public $search;
    #[Url]
    public $type;
    #[Url]
    public $category_id;
    // #[Url('q')]
    #[Url]
    public $posted;
    #[Url]
    public $from;
    #[Url]
    public $to;

    public $postToDelete;

    public $columns = [
        'id' => "Id",
        'title' => "Title",
        'date' => "Date ",
        'description' => "Description",
        'posted' => "Posted",
        'type' => "Type",
        'category_id' => "Category",
    ];

    public function with()
    {
        // $posts = Post::paginate(15);

        $categories = Category::pluck("title", "id");
        $from = $this->from;

        $posts = Post::when($this->search, function (Builder $query, string $search) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('id', 'like', "%" . $search . "%")
                    ->orWhere('title', 'like', "%" . $search . "%")
                    ->orWhere('description', 'like', "%" . $search . "%");
            });
        })
        ->when($this->type, function(Builder $query, $type) {
            $query->where('type', $type); 
        })
        ->when($this->category_id, function(Builder $query, $category_id) {
            $query->where('category_id', $category_id); 
        })
        ->when($this->posted, function(Builder $query, $posted) {
   
            $query->where('posted', $posted); 
        })
        ->when($this->type, function(Builder $query, $type) {
            $query->where('type', $type); 
        })
        ->when($this->to, function(Builder $query, $to) use($from) {
            $query->whereBetween('date', [date($from), date($this->to)]);
        })->with('category')
        ->orderBy($this->sortColumn, $this->sortDirection)
        ->paginate(15);

       

        return ['posts' => $posts, 'categories' => $categories];
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

    {{-- filter --}}
    <div class="grid grid-cols-2 gap-2 my-3">
        <flux:select class="block w-full" wire:model.live='posted'>
            <option value="">{{ __('Posted') }}</option>
            <option value="not">{{ __('Not') }}</option>
            <option value="yes">{{ __('Yes') }}</option>
        </flux:select>
        <flux:select class="block w-full" wire:model.live='type'>
            <option value="">{{ __('Type') }}</option>
            <option value="advert">{{ __('Advert') }}</option>
            <option value="post">{{ __('Post') }}</option>
            <option value="course">{{ __('Course') }}</option>
            <option value="movie">{{ __('Movie') }}</option>
        </flux:select>
        <flux:select class="block w-full" wire:model.live='category_id'>
            <option value="">{{ __('Category') }}</option>
            @foreach ($categories as $i => $c)
                <option value="{{ $i }}">{{ $c }}</option>
            @endforeach
        </flux:select>
        <flux:input wire:model.live='search' placeholder="{{ __('Search...') }}" />
        <div class="grid grid-cols-2 gap-2">
            <x-input wire:model='from' placeholder="From" type='date' />
            <x-input wire:model.live='to' placeholder="To" type='date' />
        </div>
        <div>
            <flux:button href="{{ route('volt-d-post-index') }}" class="ml-3" variant='filled'>{{ __('Clear') }}
            </flux:button>
        </div>
    </div>
    {{-- filter --}}

    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="table w-full border">
            <thead class="rounded-lg text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>

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
                    @foreach ($columns as $key => $c)
                        <th>
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
