<?php

namespace Tests\Feature\Todo;

use App\Livewire\Todo\Todo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

use App\Models\Todo as ModelsTodo;

class TodoTest extends TestCase
{
    use DatabaseMigrations;
    function setUp(): void
    {
        parent::setUp();
        User::factory(1)->create();
        $this->actingAs(User::first());
    }
    function test_index_get()
    {

        ModelsTodo::factory(5)->create();

        $this
            ->get(route('todo.list'))
            ->assertOk()
            ->assertSeeLivewire(Todo::class)
            ->assertSee("Total To Dos")
            ->assertSee("Search")
            ->assertSee("Create")
            ->assertSee("Delete All")
            ->assertSee("Save");

        Livewire::test(Todo::class)
            ->assertViewHas('todos', ModelsTodo::orderBy('count')->where('user_id', 1)->get()->toArray())
            ->assertViewIs('livewire.todo.todo');
    }
    function test_create()
    {
        Livewire::test(Todo::class)
            ->set('task', 'Name')
            ->call('save')
        ;

        $this->assertDatabaseHas('todos', [
            'name' => 'Name'
        ]);
    }
    function test_update()
    {
        ModelsTodo::factory(1)->create();

        $todoOld = ModelsTodo::first();
        $todoNew = ModelsTodo::first();

        $todoNew->name = 'New Data';

        Livewire::test(Todo::class)
            ->call('update', $todoNew);

        $this->assertDatabaseMissing('todos', [
            'name' => $todoOld->name
        ]);
        $this->assertDatabaseHas('todos', [
            'name' => $todoNew->name
        ]);
    }
    function test_delete()
    {
        ModelsTodo::factory(1)->create();

        $todo = ModelsTodo::first();

        Livewire::test(Todo::class)
            ->call('delete', $todo->id);

        $this->assertDatabaseMissing('todos', $todo->toArray());

    }
    function test_status_completed()
    {
        ModelsTodo::factory(1)->create();

        $todoOld = ModelsTodo::first();
        $todoNew = ModelsTodo::first();

        $todoNew->status = 1;

        Livewire::test(Todo::class)
            ->call('update', $todoNew);

        $this->assertDatabaseMissing('todos', [
            'status' => $todoOld->status
        ]);
        $this->assertDatabaseHas('todos', [
            'status' => $todoNew->status
        ]);
    }
    function test_status_uncompleted()
    {

        $this->test_status_completed();

        $todoOld = ModelsTodo::first();
        $todoNew = ModelsTodo::first();

        $todoNew->status = 0;

        Livewire::test(Todo::class)
            ->call('update', $todoNew);

        $this->assertDatabaseMissing('todos', [
            'status' => $todoOld->status
        ]);
        $this->assertDatabaseHas('todos', [
            'status' => $todoNew->status
        ]);
    }

    function test_reorder()
    {
        ModelsTodo::factory(5)->create();
        $todosReOrder = [2, 4, 1, 3, 5];

        Livewire::test(Todo::class)
            ->call('setOrden', $todosReOrder);

        $todosOrdened = ModelsTodo::orderBy('count')->pluck('id');
        foreach ($todosReOrder as $key => $id) {
            $this->assertTrue($id == $todosOrdened[$key]);
        }
    }

    function test_create_validation_errors()
    {
        ModelsTodo::factory(1)->create();

        Livewire::test(Todo::class)
            ->set('task', '')
            ->call('save')
            ->assertHasErrors(['task' => 'The task field is required.']);

        Livewire::test(Todo::class)
            ->set('task', 'a')
            ->call('save')
            ->assertHasErrors(['task' => 'The task field must be at least 2 characters.']);

    }

}

