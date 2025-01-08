<?php

namespace Tests\Feature\Dashboard\Category;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Storage;
use Tests\TestCase;

use App\Livewire\Dashboard\Category\Save;
use App\Models\Category;

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
            ->get(route('d-category-create'))
            ->assertOk()
            ->assertSeeLivewire(Save::class)
            ->assertSee("Send")
            ->assertSee("Title")
            ->assertSee("Text");

        Livewire::test(Save::class)
            ->assertViewIs('livewire.dashboard.category.save');
    }

    function test_create()
    {

        Livewire::test(Save::class)
            ->set('title', 'Title')
            ->call('submit')
        ;

        $this->assertDatabaseHas('categories', [
            'title' => 'Title'
        ]);
    }
    function test_edit_get()
    {

        Category::factory(1)->create();

        $this
            ->get(route('d-category-edit', 1))
            ->assertOk()
            ->assertSeeLivewire(Save::class)
            ->assertSee("Send")
            ->assertSee("Title")
            ->assertSee("Text");

        Livewire::test(Save::class, ['id' => 1])
            ->assertViewIs('livewire.dashboard.category.save');
    }

    function test_edit()
    {
        Category::factory(1)->create();
        $category = Category::first();

        Livewire::test(Save::class, ['id' => 1])
            ->set('title', 'Title')
            ->call('submit');

        $this->assertDatabaseMissing('categories', [
            'title' => $category->title
        ]);
        $this->assertDatabaseHas('categories', [
            'title' => 'Title'
        ]);
    }

    function test_edit_upload(?string $title=null)
    {
        Category::factory(1)->create();
        $category = Category::first();

        if($title){
            $category->title = $title;
        }

        $category->image = UploadedFile::fake()->image('image.jpg');

        Livewire::test(Save::class, ['id' => 1])
            ->set('title', $category->title)
            ->set('image', $category->image)
            ->call('submit');

        $category = Category::first();
        // dd($category->image);

        // dd(Storage::disk('public_upload')->path(''));

        Storage::disk('public_upload')->assertExists('images\category\\' . $category->image);

    }
    function test_create_upload()
    {

        $image = UploadedFile::fake()->image('image.jpg');

        Livewire::test(Save::class)
            ->set('title', 'Title')
            ->set('image', $image)
            ->call('submit');

        $category = Category::first();
        Storage::disk('public_upload')->assertExists('images\category\\' . $category->image);

    }

    function test_edit_delete_old_image() {
        $this->test_edit_upload();
        $categoryOld = Category::first();

        $this->test_edit_upload('Other title');
        $categoryNew = Category::first();

        Storage::disk('public_upload')->assertExists('images\category\\' . $categoryNew->image);
        Storage::disk('public_upload')->assertMissing('images\category\\' . $categoryOld->image);

    }

}
