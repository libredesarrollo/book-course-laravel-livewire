<?php

namespace Tests\Feature\Dashboard\Post;


use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;

use App\Models\Category;
use App\Models\User;
use App\Models\Post;

use App\Livewire\Dashboard\Post\Save;

use Tests\TestCase;

class SaveTest extends TestCase
{

    use DatabaseMigrations;
    function setUp(): void
    {
        parent::setUp();
        User::factory(1)->create();
        $this->actingAs(User::first());
    }
    function test_create_get()
    {

        $this
            ->get(route('d-post-create'))
            ->assertOk()
            ->assertSeeLivewire(Save::class)
            ->assertSee("Send")
            ->assertSee("Title")
            ->assertSee("Post")
            ->assertSee("Text");

        Livewire::test(Save::class)
            ->assertViewHas('categories', Category::get())
            ->assertViewIs('livewire.dashboard.post.save');
    }

    function test_create()
    {
        Category::factory(1)->create();
        Livewire::test(Save::class)
            ->set('title', 'Title')
            ->set('description', 'Description')
            ->set('text', 'Text')
            ->set('type', 'post')
            ->set('posted', 'yes')
            ->set('category_id', 1)
            ->set('date', Carbon::now())
            // ->set('image', null)
            ->call('submit')
        ;

        $this->assertDatabaseHas('posts', [
            'title' => 'Title',
            'description' => 'Description',
        ]);
    }
    function test_edit_get()
    {
        Category::factory(3)->create();
        Post::factory(1)->create();

        $this
            ->get(route('d-post-edit', 1))
            ->assertOk()
            ->assertSeeLivewire(Save::class)
            ->assertSee("Send")
            ->assertSee("Title")
            ->assertSee("Text");

        Livewire::test(Save::class, ['id' => 1])
            ->assertViewHas('categories', Category::get())
            ->assertViewIs('livewire.dashboard.post.save');
    }

    function test_edit()
    {
        Category::factory(3)->create();
        Post::factory(1)->create();
        $post = Post::first();

        Livewire::test(Save::class, ['id' => 1])
            ->set('title', 'Title')
            ->set('description', 'Description')
            ->set('text', 'Text')
            ->set('type', 'post')
            ->set('posted', 'yes')
            ->set('date', value: Carbon::now())
            // ->set('image', null)
            ->call('submit');

        $this->assertDatabaseMissing('posts', [
            'title' => $post->title
        ]);
        $this->assertDatabaseHas('posts', [
            'title' => 'Title'
        ]);
    }
    

}
