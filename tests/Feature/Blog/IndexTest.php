<?php

namespace Tests\Feature\Blog;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
// use PHPUnit\Framework\TestCase;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

use App\Livewire\Blog\Index;
use App\Models\Post;

class IndexTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {

        Category::factory(3)->create();
        Post::factory(30)->create();

        $this
            ->get(route('web.index'))
            ->assertSeeLivewire(Index::class)
            ->assertStatus(200)
            ->assertSee("Post List")
            // ->assertViewHas('posts', Post::paginate(15))
            // ->assertViewIs('livewire.blog.index');
        ;

        Livewire::test(Index::class)
            ->assertSee("Post List")
            ->assertViewHas('posts', Post::with('category')
                ->where('posted', 'yes')->paginate(15))
                ->assertViewIs('livewire.blog.index')
            // ->assertViewHas('posts', function ($posts){
            //     dd(Post::paginate(15));
            //     dd($posts);
            // })
        ;

        // dd($response);
        // $response->assertStatus(200);
    }
    public function test_index_filter(): void
    {
        Category::factory(3)->create();
        Post::factory(100)->create();

        $this
            ->get(route('web.index'))
            ->assertSeeLivewire(Index::class)
            ->assertStatus(200)
            ->assertSee("Post List")
            // ->assertViewHas('posts', Post::paginate(15))
            // ->assertViewIs('livewire.blog.index');
        ;

        Livewire::test(Index::class)
            ->assertSee("Post List")
            ->set('category_id',1)
            ->set('type','post')
            ->assertViewHas('posts', Post::with('category')
                ->where('posted', 'yes')
                ->where('type', 'post')
                ->where('category_id', 1)
                ->paginate(15))
                ->assertViewIs('livewire.blog.index')
            // ->assertViewHas('posts', function ($posts){
            //     dd(Post::paginate(15));
            //     dd($posts);
            // })
        ;

        // dd($response);
        // $response->assertStatus(200);
    }
}
