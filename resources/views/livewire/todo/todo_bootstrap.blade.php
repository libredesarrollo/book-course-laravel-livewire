{{-- <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

{{-- <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script> --}}

{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 --}}

<div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <div x-data="data()" x-init="order()" class="container my-3" style="max-width: 500px;">

        <div class="card">
            <div class="card-header">
                <h4>Total To Dos: <span x-text="totalTodos()"></span></h4>
            </div>
            <div class="card-body">


                <div class="row g-2">
                    <div class="col-auto">
                        <label class="col-form-label">
                            Search
                        </label>
                    </div>
                    <div class="col-auto">
                        <input type="text" x-model="search" class="form-control">
                    </div>
                </div>

                <form wire:submit.prevent="save()" class="row g-2 mt-2">

                    <div class="col-auto">
                        <label class="col-form-label">Create</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" wire:model="task" class="form-control">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>


                <ul x-ref="items" class="list-group my-3">
                    <template x-for="t in filterTodo()">
                        <li :id='t.id' class="list-group-item">
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

                            <input type="checkbox" x-model="t.status" @change="$wire.dispatch('update', { todo: t })" :checked="t.status == 1">
                            <span x-text="t.name" @click="t.editMode=true" x-show="!t.editMode"></span>
                            <input type="text" @keyup.enter="t.editMode=false; $wire.dispatch('update', { todo: t })" x-model="t.name"
                                x-show="t.editMode" />

                            <button class="btn btn-sm btn-close float-end" @click="remove(t)"></button>
                        </li>
                    </template>
                </ul>

                <button class="btn btn-danger" @click="removeAll">Delete All</button>
            </div>
        </div>

    </div>
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

                            document.querySelectorAll('.list-group li').forEach((todoHTML => {
                                todosPKs.push(todoHTML.id)
                                // this.todos.forEach(todo => {
                                //     if(todo.id == todoHTML.id){
                                //         todosAux.push(todo)
                                //     }
                                // })
                            }))

                            // this.todos = todosAux
                            Livewire.dispatch('setOrden', {pks:todosPKs})
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
                    Livewire.dispatch('delete', {id:todo.id})
                },
                removeAll(){
                    this.todos=[]
                    Livewire.dispatch('delete')
                },
            }
            //  }
        })
    </script>
@endscript
