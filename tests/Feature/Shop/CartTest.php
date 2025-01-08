<?php

namespace Tests\Feature\Shop;

use App\Livewire\Shop\CartItem;
use App\Models\Category;
use App\Models\Post;
use App\Models\ShoppingCart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;

use Tests\TestCase;
use App\Livewire\Shop\Cart;
use App\Models\User;

class CartTest extends TestCase
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
        $this
            ->get(route('shop.cart.list'))
            ->assertStatus(200)
            ->assertSeeLivewire(Cart::class)
            ->assertSee("Shopping cart");

        Livewire::test(Cart::class)
            ->assertViewIs('livewire.shop.cart');
    }
    public function test_create_db_session_post(): void
    {
        Category::factory(3)->create();
        Post::factory(1)->create();

        Livewire::test(Cart::class, ['post' => Post::first(), 'type' => 'add'])
            ->assertViewIs('livewire.shop.cart-add');

        Livewire::test(CartItem::class, ['postId' => 1])
            ->assertViewIs('livewire.shop.cart-item')
            ->call('add', Post::first());

        $this->assertEquals(1, session('cart')[1][0]->id);
        $this->assertEquals(1, session('cart')[1][1]);

        $this->assertDatabaseHas(
            'shopping_carts',
            [
                'user_id' => 1,
                'post_id' => 1,
                'count' => 1
            ]
        );
    }
    public function test_update_db_session_post(): void
    {

        $this->test_create_db_session_post();

        // update current item cart count 3
        Livewire::test(CartItem::class, ['postId' => 1])
            ->assertViewIs('livewire.shop.cart-item')
            ->call('add', post:Post::first(),count:3);

        $this->assertEquals(1, session('cart')[1][0]->id);
        $this->assertEquals(3, session('cart')[1][1]);

        $this->assertDatabaseHas(
            'shopping_carts',
            [
                'user_id' => 1,
                'post_id' => 1,
                'count' => 3
            ]
        );
        $this->assertDatabaseMissing(
            'shopping_carts',
            [
                'user_id' => 1,
                'post_id' => 1,
                'count' => 1
            ]
        );
    }
    public function test_delete_db_session_post(): void
    {

        $this->test_create_db_session_post();
        
        // sleep(1);
        // delete current item cart count 0
        Livewire::test(CartItem::class, ['postId' => 1])
            ->assertViewIs('livewire.shop.cart-item')
            ->call('add', post:Post::first(),count:0);
            // ->call('add', ['post'=>Post::first(),'count' =>0]);

        $this->assertEquals([], session('cart'));
        
        // $this->assertDatabaseMissing(
        //     'shopping_carts',
        //     [
        //         'user_id' => 1,
        //         'post_id' => 1,
        //         // 'count' => 1
        //     ]
        // );
    }
    public function test_delete_not_exist_db_session_post(): void
    {

        // $this->test_create_db_session_post();
  
        Livewire::test(CartItem::class, ['postId' => 1])
            ->assertViewIs('livewire.shop.cart-item')
            ->call('add',count:0);

        $this->assertNull( session('cart'));
    
    }


}
