<?php

namespace Tests\Feature\Dashboard\Category;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

use App\Livewire\Dashboard\Category\Index;
use App\Models\Category;

class IndexTest extends TestCase
{

    use DatabaseMigrations;

    function setUp(): void
    {
        parent::setUp();
        User::factory(1)->create();
        $this->actingAs(User::first());
    }

    public function test_index(): void
    {

        Category::factory(3)->create();

        $this
            ->get(route('d-category-index'))
            ->assertStatus(200)
            ->assertSeeLivewire(Index::class)
            ->assertSee("Create")
            ->assertSee("Title")
            ->assertSee("Actions")
            ->assertSee("Delete")
            ->assertSee("Edit")
        ;

        Livewire::test(Index::class)
            ->assertViewHas('categories', Category::paginate(2))
            ->assertViewIs('livewire.dashboard.category.index');
    }

    function test_delete()
    {
        Category::factory(1)->create();
        $category = Category::first();

        Livewire::test(Index::class)
            ->set('categoryToDelete', $category)
            ->call('delete');

        $this->assertDatabaseMissing('categories', [
            'title' => $category->title
        ]);
    }
    function test_delete_2_form()
    {
        Category::factory(1)->create();
        $category = Category::first();

        Livewire::test(Index::class)
            ->call('selectCategoryToDelete', $category)
            ->call('delete');

        $this->assertDatabaseMissing('categories', [
            'title' => $category->title
        ]);
    }


}