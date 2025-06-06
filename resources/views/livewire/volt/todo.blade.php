<?php

use Livewire\Volt\Component;

use Livewire\Attributes\On;
use App\Models\Todo as ModelsTodo;

new class extends Component {
    public $task;
    public $todos;

    // protected $listeners = ['addTodo', 'setOrden', 'update'];

    protected $rules = [
        'task' => 'required|min:2|max:255',
    ];

    function mount()
    {
        $this->todos = ModelsTodo::orderBy('count')
            ->where('user_id', auth()->id())
            ->get()
            ->toArray();
    }

    function save()
    {
        $this->validate();

        $todo = ModelsTodo::create([
            'name' => $this->task,
            'user_id' => auth()->id(),
            'count' => ModelsTodo::where('user_id', auth()->id())->count(),
        ]);

        $this->dispatch('addTodo', $todo);
    }

    #[On('setOrden')]
    function setOrden($pks)
    {
        // foreach($this->todos as $count => $t){
        //dd($pks);
        foreach ($pks as $count => $t) {
            ModelsTodo::where('user_id', auth()->id())
                ->where('id', $t)
                // ->where('id', $t['id'])
                ->update(['count' => $count]);
        }
    }
    #[On('delete')]
    function delete($id = null)
    {
        if ($id) {
            ModelsTodo::where('user_id', auth()->id())
                ->where('id', $id)
                ->delete();
        } else {
            ModelsTodo::where('user_id', auth()->id())->delete();
        }
    }
    #[On('update')]
    function update($todo = null)
    {
        if ($todo == null) {
            return;
        }
        ModelsTodo::where('user_id', auth()->id())
            ->where('id', $todo['id'])
            ->update([
                'name' => $todo['name'],
                'status' => $todo['status'],
            ]);
    }
}; ?>

<div x-data="data()" x-init="order()" class="container my-3" style="max-width: 500px;">

    <x-card>
        @slot('title')
            Total To Dos: <span x-text="totalTodos()"></span>
        @endslot

        {{-- search --}}
        <label class="col-form-label">
            Search
        </label>
        <flux:input type="text" x-model="search" class="form-control" />
        {{-- search --}}

        {{-- create --}}
        <form wire:submit.prevent="save()" class="flex gap-2 mt-2">
            <label class="mt-2">Create</label>
            <flux:input type="text" wire:model="task" class="form-control" />

            <flux:button type="submit">Save</flux:button>
        </form>
        @error('task')
            <p class="text-red-800">{{ $message }}</p>
        @enderror
        {{-- create --}}

        {{-- list --}}
        <ul x-ref="items" class="my-3">
            <template x-for="t in filterTodo()">
                <li :id='t.id' class="border py-3 px-4 mt-2">
                    <flux:button variant="danger" size='xs' @click="remove(t)" class="float-right mt-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </flux:button>
                    <template x-if="completed(t)">
                        <span>
                            Completed -
                        </span>
                    </template>
                    <template x-if="!completed(t)">
                        <span>
                            Incompleted -
                        </span>
                    </template>

                    <input type="checkbox" x-model="t.status" @change="$wire.dispatch('update', { todo: t })"
                        :checked="t.status == 1">
                    <span x-text="t.name" @click="t.editMode=true" x-show="!t.editMode"></span>
                    <flux:input type="text" @keyup.enter="t.editMode=false; $wire.dispatch('update', { todo: t })"
                        x-model="t.name" x-show="t.editMode" />


                </li>
            </template>
        </ul>
        {{-- list --}}

        <flux:button variant="danger" @click="removeAll">Delete All</flux:button>
    </x-card>

</div>


@script
    <script>
        Alpine.data('data', () => {
            //  function data() {
            return {
                // todos: $wire.entangle('todos'),
                todos: $wire.get('todos'),
                // todos: Alpine.$persist([]),

                search: '',
                task: '',
                count: Alpine.$persist(10),
                order() {

                    $wire.on('addTodo', (arrgs) => {
                        this.todos.push(arrgs[0])
                    })

                    Sortable.create(this.$refs.items, {
                        onEnd: (event) => {
                            // var todosAux = []
                            var todosPKs = []

                            //document.querySelectorAll('.list-group li').forEach((todoHTML => {

                            $refs.items.querySelectorAll('li').forEach((todoHTML => {
                                todosPKs.push(todoHTML.id)
                                // this.todos.forEach(todo => {
                                //     if(todo.id == todoHTML.id){
                                //         todosAux.push(todo)
                                //     }
                                // })
                            }))
                            // console.log(todosPKs)
                            // this.todos = todosAux
                            Livewire.dispatch('setOrden', {
                                pks: todosPKs
                            })
                        }
                    })
                },
                completed(todo) {
                    return todo.status == 1
                },
                totalTodos() {
                    return this.todos.length
                },
                filterTodo() {
                    return this.todos.filter((t) => t.name.toLowerCase().includes(this.search.toLowerCase()))
                },
                remove(todo) {
                    this.todos = this.todos.filter((t) => t != todo)
                    Livewire.dispatch('delete', {
                        id: todo.id
                    })
                },
                removeAll() {
                    this.todos = []
                    Livewire.dispatch('delete')
                },
            }
            //  }
        })
    </script>
@endscript
