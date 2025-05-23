<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::group([
        'prefix' => 'dashboard'
    ], function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');


        //category
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', App\Livewire\Dashboard\Category\Index::class)->name("d-category-index");
            Route::get('/create', App\Livewire\Dashboard\Category\Save::class)->name("d-category-create");
            Route::get('/edit/{id}', App\Livewire\Dashboard\Category\Save::class)->name("d-category-edit");

            // demo volt
            Volt::route('volt', 'volt.dashboard.category.index')->name('volt-d-category-index');
            Volt::route('volt/create', 'volt.dashboard.category.save')->name('volt-d-category-create');
            Volt::route('volt/edit/{id}', 'volt.dashboard.category.save')->name('volt-d-category-edit');
        });

        // post
        Route::group(['prefix' => 'post'], function () {
            Route::get('/', App\Livewire\Dashboard\Post\Index::class)->name("d-post-index");        // listado
            Route::get('/create', App\Livewire\Dashboard\Post\Save::class)->name("d-post-create");  // crear
            Route::get('/edit/{id}', App\Livewire\Dashboard\Post\Save::class)->name("d-post-edit"); // edit

            Volt::route('volt', 'volt.dashboard.post.index')->name('volt-d-post-index');
            Volt::route('volt/create', 'volt.dashboard.post.save')->name('volt-d-post-create');
            Volt::route('volt/edit/{id}', 'volt.dashboard.post.save')->name('volt-d-post-edit');
        });


        //post
        // Route::group(['prefix' => 'post'], function () {
        //     Route::get('/', App\Livewire\Dashboard\Post\Index::class)->name("d-post-index");
        //     Route::get('/create', App\Livewire\Dashboard\Post\Save::class)->name("d-post-create");
        //     Route::get('/edit/{id}', App\Livewire\Dashboard\Post\Save::class)->name("d-post-edit");
        // });


        // //tag
        // Route::group(['prefix' => 'tag'], function () {
        //     Route::get('/', App\Livewire\Dashboard\Tag\Index::class)->name("d-tag-index");
        //     Route::get('/create', App\Livewire\Dashboard\Tag\Save::class)->name("d-tag-create");
        //     Route::get('/edit/{id}', App\Livewire\Dashboard\Tag\Save::class)->name("d-tag-edit");
        // });
    });

    Route::get('contact', App\Livewire\Contact\General::class)->name("contact");
    Route::get('contact/{id}/{step?}', App\Livewire\Contact\General::class)->name("contact-edit");

    // demo volt
    Volt::route('volt/contact', 'volt.contact.general')->name('volt-d-category-index');
    Volt::route('volt/contact/{id}/{step?}', 'volt.contact.general')->name('volt-d-category-create');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    
});

//shopping
Route::group(['prefix' => 'shop'], function () {
    Route::get('/cart-list', App\Livewire\Shop\Cart::class)->name('shop.cart.list');
    Volt::route('volt/cart-list', 'volt.shop.cart')->name('volt.shop.cart.list');
});

// blog
Route::group(['prefix' => 'blog'], function () {

    Volt::route('volt', 'volt.blog.index')->name('volt.web.index');
    Volt::route('volt/{post:slug}', 'volt.blog.show')->name('volt.web.show');

    Route::get('/', App\Livewire\Blog\Index::class)->name('web.index');
    Route::get('/{post:slug}', App\Livewire\Blog\Show::class)->name('web.show');
});

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'todo'
], function () {
    Route::get('/', App\Livewire\Todo\Todo::class)->name('todo.list');
    Volt::route('volt', 'volt.todo')->name('volt.todo.list');
});

require __DIR__ . '/auth.php';
