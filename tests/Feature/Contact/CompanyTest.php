<?php

namespace Tests\Feature\Contact;

use App\Models\ContactCompany;
use App\Models\ContactGeneral;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

use App\Livewire\Contact\Company;

class CompanyTest extends TestCase
{

    use DatabaseMigrations;
    public function test_create_get(): void
    {

        Livewire::test(Company::class, ['parentId' => 1])
            ->assertSee('Name')
            ->assertSee('Email')
            ->assertSee('Identification')
            ->assertSee('Choices')
            ->assertSee('Extra')
            ->assertSee('Send')
            ->assertSee('Back')
            ->assertViewIs('livewire.contact.company');
    }

    function test_create()
    {
        ContactGeneral::factory(1)->create();

        Livewire::test(Company::class, ['parentId' => 1])
            ->set('name', 'Name')
            ->set('identification', 'Identification')
            ->set('email', 'company@gmail.com')
            ->set('extra', 'extra')
            ->set('choices', 'post')
            ->call('submit')
            ->assertDispatched('stepEvent', function ($eventName, $params) {
                return $params[0] == 3;
            });

        $this->assertDatabaseHas('contact_companies', [
            'name' => 'Name',
            'identification' => 'Identification',
            'email' => 'company@gmail.com',
            'extra' => 'extra',
            'choices' => 'post',
            'contact_general_id' => 1
        ]);
    }
    public function test_edit_get(): void
    {
        ContactGeneral::factory(1)->create();
        ContactCompany::factory(1)->create();

        $contactCompany = ContactCompany::first();

        Livewire::test(Company::class, ['parentId' => 1])
            ->assertSee('Name')
            ->assertSee('Email')
            ->assertSee('Identification')
            ->assertSee('Choices')
            ->assertSee('Extra')
            ->assertSee('Send')
            ->assertSee('Back')
            ->assertViewHas('name', $contactCompany->name)
            ->assertViewHas('identification', $contactCompany->identification)
            ->assertViewHas('choices', $contactCompany->choices)
            ->assertViewHas('extra', $contactCompany->extra)
            ->assertViewHas('email', $contactCompany->email)
            ->assertViewIs('livewire.contact.company');
    }

    function test_edit()
    {
        ContactGeneral::factory(1)->create();
        ContactCompany::factory(1)->create();

        $contactCompany = ContactCompany::first();

        Livewire::test(Company::class, ['parentId' => 1])
            ->set('name', 'Name')
            ->set('identification', 'Identification')
            ->set('email', 'company@gmail.com')
            ->set('extra', 'extra')
            ->set('choices', 'post')
            ->call('submit')
            ->assertDispatched('stepEvent', function ($eventName, $params) {
                return $params[0] == 3;
            });

        $this->assertDatabaseMissing('contact_companies', [
            'name' => $contactCompany->name,
            'identification' => $contactCompany->identification,
            'extra' => $contactCompany->extra,
            'choices' => $contactCompany->choices,
            'email' => $contactCompany->email
        ]);

        $this->assertDatabaseHas('contact_companies', [
            'name' => 'Name',
            'identification' => 'Identification',
            'email' => 'company@gmail.com',
            'extra' => 'extra',
            'choices' => 'post',
            'contact_general_id' => 1
        ]);
    }

    // validation errors

    function test_create_validation_errors()
    {
        ContactGeneral::factory(1)->create();

        Livewire::test(Company::class, ['parentId' => 1])
            ->set('name', '')
            ->set('identification', '')
            ->set('email', '')
            // ->set('extra', 'extra')
            // ->set('choices', 'post')
            ->call('submit')
            ->assertHasErrors(['name', 'identification', 'email'])
            ->assertHasErrors(['name' => 'The name field is required.']);

    }
    function test_edit_validation_errors()
    {
        ContactGeneral::factory(1)->create();
        ContactCompany::factory(1)->create();

        $contactCompany = ContactCompany::first();

        Livewire::test(Company::class, ['parentId' => 1])
            ->set('name', '')
            ->set('identification', '')
            ->set('email', '')
            ->set('extra', 'extra')
            ->set('choices', 'post')
            ->call('submit')
            ->assertHasErrors(['name', 'identification', 'email'])
            ->assertHasErrors(['name' => 'The name field is required.']);

        $this->assertDatabaseHas('contact_companies', [
            'name' => $contactCompany->name,
            'identification' => $contactCompany->identification,
            'extra' => $contactCompany->extra,
            'choices' => $contactCompany->choices,
            'email' => $contactCompany->email
        ]);
    }
}
