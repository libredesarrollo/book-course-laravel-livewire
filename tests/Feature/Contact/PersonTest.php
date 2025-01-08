<?php

namespace Tests\Feature\Contact;

use App\Models\ContactGeneral;
use App\Models\ContactPerson;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

use App\Livewire\Contact\Person;

class PersonTest extends TestCase
{

    use DatabaseMigrations;
    public function test_create_get(): void
    {

        Livewire::test(Person::class, ['parentId' => 1])
            ->assertSee('Name')
            ->assertSee('Surname')
            ->assertSee('Other')
            ->assertSee('Choices')
            ->assertSee('Send')
            ->assertSee('Back')
            ->assertViewIs('livewire.contact.person');
    }

    function test_create()
    {
        ContactGeneral::factory(1)->create();

        Livewire::test(Person::class, ['parentId' => 1])
            ->set('name', 'Name')
            ->set('surname', 'Surmame')
            ->set('other', 'Other')
            ->set('choices', 'post')
            ->call('submit');

        $this->assertDatabaseHas('contact_persons', [
            'name' => 'Name',
            'surname' => 'Surmame',
            'other' => 'Other',
            'choices' => 'post',
            'contact_general_id' => 1
        ]);
    }

    public function test_edit_get(): void
    {
        ContactGeneral::factory(1)->create();
        ContactPerson::factory(1)->create();

        $contactPerson = ContactPerson::first();

        Livewire::test(Person::class, ['parentId' => 1])
            ->assertSee('Name')
            ->assertSee('Surname')
            ->assertSee('Other')
            ->assertSee('post')
            ->assertSee('Send')
            ->assertSee('Back')
            ->assertViewHas('name', $contactPerson->name)
            ->assertViewHas('surname', $contactPerson->surname)
            ->assertViewHas('other', $contactPerson->other)
            ->assertViewHas('choices', $contactPerson->choices)
            ->assertViewIs('livewire.contact.person');
    }

    function test_edit()
    {
        ContactGeneral::factory(1)->create();
        ContactPerson::factory(1)->create();

        $contactPerson = ContactPerson::first();

        Livewire::test(Person::class, ['parentId' => 1])
            ->set('name', 'Name')
            ->set('surname', 'Surname')
            ->set('other', 'Other')
            ->set('choices', 'post')
            ->call('submit')
            ->assertDispatched('stepEvent', function ($eventName, $params) {
                return $params[0] == 3;
            });

        $this->assertDatabaseMissing('contact_persons', [
            'name' => $contactPerson->name,
            'surname' => $contactPerson->surname,
            'other' => $contactPerson->other,
            'choices' => $contactPerson->choices
        ]);

        $this->assertDatabaseHas('contact_persons', [
            'name' => 'Name',
            'surname' => 'Surname',
            'other' => 'Other',
            'choices' => 'post',
            'contact_general_id' => 1
        ]);
    }

    // validation errors
    function test_create_validation_errors()
    {
        ContactGeneral::factory(1)->create();

        Livewire::test(Person::class, ['parentId' => 1])
            ->set('name', '')
            ->set('surname', 's')
            // ->set('choices', 'post')
            ->call('submit')
            ->assertHasErrors(['name', 'surname'])
            ->assertHasErrors(['surname' => 'The surname field must be at least 2 characters.'])
            ->assertHasErrors(['name' => 'The name field is required.'])
        ;

    }
    function test_edit_validation_errors()
    {
        ContactGeneral::factory(1)->create();
        ContactPerson::factory(1)->create();

        $contactCompany = ContactPerson::first();

        Livewire::test(Person::class, ['parentId' => 1])
            ->set('name', '')
            ->set('surname', 's')
            ->set('choices', 'post')
            ->call('submit')
            ->assertHasErrors(['name', 'surname'])
            ->assertHasErrors(['name' => 'The name field is required.']);

        $this->assertDatabaseHas('contact_persons', [
            'name' => $contactCompany->name,
            'surname' => $contactCompany->surname,
            'other' => $contactCompany->other,
            'choices' => $contactCompany->choices
        ]);
    }
}