<?php

namespace Tests\Feature\Contact;

use App\Models\ContactDetail;
use App\Models\ContactGeneral;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

use App\Livewire\Contact\Detail;

class DetailTest extends TestCase
{

    use DatabaseMigrations;
    public function test_create_get(): void
    {

        Livewire::test(Detail::class, ['parentId' => 1])
            ->assertSee('Extra')
            ->assertSee('Send')
            ->assertSee('Back')
            ->assertViewIs('livewire.contact.detail');
    }

    function test_create()
    {
        ContactGeneral::factory(1)->create();

        Livewire::test(Detail::class, ['parentId' => 1])
            ->set('extra', 'Extra')
            ->call('submit');

        $this->assertDatabaseHas('contact_details', [
            'extra' => 'Extra',
            'contact_general_id' => 1
        ]);
    }

    public function test_edit_get(): void
    {
        ContactGeneral::factory(1)->create();
        ContactDetail::factory(1)->create();

        $contactDetail = ContactDetail::first();

        Livewire::test(Detail::class, ['parentId' => 1])
            ->assertSee('Extra')
            ->assertSee('Send')
            ->assertSee('Back')
            ->assertViewHas('extra', $contactDetail->extra)
            ->assertViewIs('livewire.contact.detail');
    }

    function test_edit()
    {
        ContactGeneral::factory(1)->create();
        ContactDetail::factory(1)->create();

        $contactDetail = ContactDetail::first();

        Livewire::test(Detail::class, ['parentId' => 1])
            ->set('extra', 'Extra')
            ->call('submit')
            ->assertDispatched('stepEvent', function ($eventName, $params) {
                return $params[0] == 4;
            });

        $this->assertDatabaseMissing('contact_details', [
            'extra' => $contactDetail->extra
        ]);

        $this->assertDatabaseHas('contact_details', [
            'extra' => 'Extra'
        ]);
    }

    // validation errors
    function test_create_validation_errors()
    {
        ContactGeneral::factory(1)->create();

        Livewire::test(Detail::class, ['parentId' => 1])
            ->set('extra', '')
            ->call('submit')
            ->assertHasErrors(['extra' => 'The extra field is required.']);

        Livewire::test(Detail::class, ['parentId' => 1])
            ->set('extra', 'a')
            ->call('submit')
            ->assertHasErrors(['extra' => 'The extra field must be at least 2 characters.']);

    }
    function test_edit_validation_errors()
    {
        ContactGeneral::factory(1)->create();
        ContactDetail::factory(1)->create();

        $contactCompany = ContactDetail::first();

        Livewire::test(Detail::class, ['parentId' => 1])
            ->set('extra', '')
            ->call('submit')
            ->assertHasErrors(['extra' => 'The extra field is required.']);

        $this->assertDatabaseHas('contact_details', [
            'extra' => $contactCompany->extra
        ]);
    }
}
