<?php

namespace Tests\Feature\Contact;


use App\Models\ContactGeneral;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

use App\Livewire\Contact\General;

class GeneralTest extends TestCase
{
    use DatabaseMigrations;
    public function test_create_get(): void
    {

        $this->get(route('contact'))->assertOk();

        Livewire::test(General::class)
            ->assertSee('Subject')
            ->assertSee('Type')
            ->assertSee('Message')
            ->assertViewHas('step', 1)
            ->assertViewIs('livewire.contact.general');
    }

    function test_create()
    {
        Livewire::test(General::class)
            ->set('subject', 'Subject')
            ->set('type', 'company')
            ->set('message', 'Text')
            // ->set('image', null)
            ->call('submit');

        $this->assertDatabaseHas('contact_generals', [
            'subject' => 'Subject',
            'type' => 'company',
            'message' => 'Text'
        ]);
    }
    public function test_edit_get(): void
    {

        ContactGeneral::factory(1)->create();
        $contactGeneral = ContactGeneral::first();

        $this->get(route('contact-edit', ['id' => 1]))->assertOk();

        Livewire::test(General::class, ['id' => 1])
            ->assertSee('Subject')
            ->assertSee('Type')
            ->assertSee('Message')
            ->assertViewHas('subject', $contactGeneral->subject)
            ->assertViewHas('type', $contactGeneral->type)
            ->assertViewHas('message', $contactGeneral->message)
            ->assertViewHas('step', 1)
            ->assertViewIs('livewire.contact.general');
    }

    function test_edit()
    {

        ContactGeneral::factory(1)->create();
        $contactGeneral = ContactGeneral::first();

        Livewire::test(General::class, ['id' => 1])
            ->set('subject', 'Subject')
            ->set('type', 'company')
            ->set('message', 'Text')
            // ->set('image', null)
            ->call('submit');

        $this->assertDatabaseMissing('contact_generals', [
            'subject' => $contactGeneral->subject,
            'type' => $contactGeneral->type,
            'message' => $contactGeneral->message
        ]);
        $this->assertDatabaseHas('contact_generals', [
            'subject' => 'Subject',
            'type' => 'company',
            'message' => 'Text'
        ]);
    }


    // errors validations
    function test_create_validation_errors()
    {
        Livewire::test(General::class)
            ->set('subject', '')
            ->set('type', '')
            ->set('message', '')
            ->call('submit')
            ->assertHasErrors(['subject', 'type', 'message'])
            ->assertHasErrors(['subject' => 'The subject field is required.']);
    }

    function test_edit_validation_errors()
    {

        ContactGeneral::factory(1)->create();
        $contactGeneral = ContactGeneral::first();

        Livewire::test(General::class, ['id' => 1])
            ->set('subject', '')
            ->set('type', '')
            ->set('message', '')
            ->call('submit')
            ->assertHasErrors(['subject', 'type', 'message'])
            ->assertHasErrors('type')
            ->assertHasErrors(['subject' => 'The subject field is required.']);

        $this->assertDatabaseHas('contact_generals', [
            'subject' => $contactGeneral->subject,
            'type' => $contactGeneral->type,
            'message' => $contactGeneral->message
        ]);
    }
}
