<?php

namespace Tests\Feature\Dashboard\Post;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

use App\Livewire\Dashboard\Post\Index;
use App\Models\Post;

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
        Post::factory(15)->create();

        $this
            ->get(route('d-post-index'))
            ->assertStatus(200)
            ->assertSeeLivewire(Index::class)
            ->assertSee("Create")
            ->assertSee("Title")
            ->assertSee("Actions")
            ->assertSee("Delete")
            ->assertSee("Edit")
        ;

        Livewire::test(Index::class)
            ->assertViewHas('posts', Post::with('category')
                ->orderBy('id', 'desc')
                ->paginate(15))
                ->assertViewHas('categories', Category::pluck("title", "id"))
            ->assertViewIs('livewire.dashboard.post.index');
    }


    function test_delete()
    {
        Category::factory(3)->create();
        Post::factory(1)->create();
        $post = Post::first();

        Livewire::test(Index::class)
            ->call('selectPostToDelete', $post)
            ->call('delete');

        $this->assertDatabaseMissing('posts', [
            'title' => $post->title
        ]);
    }


}