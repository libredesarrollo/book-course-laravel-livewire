<?php

namespace Tests\Feature\Blog;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
// use PHPUnit\Framework\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

use App\Livewire\Blog\Show;
use App\Models\Category;
use App\Models\Post;

class ShowTest extends TestCase
{
    use DatabaseMigrations;
    public function test_show(): void
    {
        Category::factory(3)->create();
        Post::factory(1)->create();
        
        $post = Post::first();

        $this
            ->get(route('web.show', ['post' => $post->slug]))
            ->assertSeeLivewire(Show::class)
            ->assertStatus(200)
            ->assertSee($post->title);

        Livewire::test(Show::class, ['post' => $post])
            ->assertSee($post->title)
            ->assertSee($post->category->title)
            ->assertSee($post->type)
            ->assertSee($post->text)
            ->assertViewHas('post', value: $post)
            ->assertViewIs('livewire.blog.show')
        ;

    }
}
