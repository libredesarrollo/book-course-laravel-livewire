<?php

namespace App\Livewire\Todo;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Todo as ModelsTodo;

class Todo extends Component
{
    public $task;
    public $todos;

    // protected $listeners = ['addTodo', 'setOrden', 'update'];

    public function render()
    {
        $this->todos = ModelsTodo::orderBy('count')->where('user_id', auth()->id())->get()->toArray();
        return view('livewire.todo.todo');
    }

    function save()
    {
        $todo = ModelsTodo::create(
            [
                'name' => $this->task,
                'user_id' => auth()->id(),
                'count' => ModelsTodo::where('user_id', auth()->id())->count(),
            ]
        );

        $this->dispatch('addTodo', $todo);
    }

    #[On('setOrden')]
    function setOrden($pks)
    {
        // foreach($this->todos as $count => $t){

        foreach ($pks as $count => $t) {
            ModelsTodo::
                where('user_id', auth()->id())
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
                ->where('id', $id)->delete();
        } else {
            ModelsTodo::where('user_id', auth()->id())->delete();
        }

    }
    #[On('update')]
    function update($todo = null)
    {
        if($todo == null) {
            return;
        }
        ModelsTodo::where('user_id', auth()->id())
            ->where('id', $todo['id'])->update([
                    'name' => $todo['name'],
                    'status' => $todo['status'],
                ]);
    }
}
