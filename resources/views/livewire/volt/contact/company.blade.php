<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    //
    public $name;
    public $identification;
    public $choices;
    public $extra;
    public $email;

    protected $rules = [
        'name' => 'required|min:2|max:255',
        'email' => 'required|min:2|max:80',
        'identification' => 'required|min:2|max:50',
        'choices' => 'required',
        'extra' => 'required|min:2|max:255',
    ];

    public $parentId;

    protected $listeners = ['parentId'];

    function mount($parentId)
    {
        $this->parentId($parentId);
    }

    function parentId($parentId)
    {
        $this->parentId = $parentId;
        $c = ContactCompany::where('contact_general_id', $this->parentId)->first();
        if ($c != null) {
            $this->name = $c->name;
            $this->identification = $c->identification;
            $this->extra = $c->extra;
            $this->choices = $c->choices;
            $this->email = $c->email;
        }
    }

    public function render()
    {
        return view('livewire.contact.company');
    }

    function submit()
    {
        $this->validate();

        ContactCompany::updateOrCreate(
            ['contact_general_id' => $this->parentId],
            [
                'name' => $this->name,
                'identification' => $this->identification,
                'email' => $this->email,
                'extra' => $this->extra,
                'choices' => $this->choices,
                'contact_general_id' => $this->parentId,
            ],
        );

        $this->dispatch('stepEvent', 3);
    }

    function back()
    {
        $this->dispatch('stepEvent', 1);
    }
}; ?>

<div>
    <form wire:submit.prevent='submit' class="flex flex-col max-w-sm mx-auto">
        <flux:label>{{ __('Name') }}</flux:label>
        <flux:error name='name' />
        <flux:input type='text' wire:model='name' />

        <flux:label>{{ __('Email') }}</flux:label>
        <flux:error name='email' />
        <flux:input type='email' wire:model='email' />

        <flux:label>{{ __('Identification') }}</flux:label>
        <flux:error name='identification' />
        <flux:input type='text' wire:model='identification' />

        <flux:label>{{ __('Choices') }}</flux:label>
        <flux:error name='choice' />
        <flux:select wire:model='choices'>
            <option value=""></option>
            <option value="advert">{{ __('Advert') }}</option>
            <option value="post">{{ __('Post') }}</option>
            <option value="course">{{ __('Course') }}</option>
            <option value="movie">{{ __('Movie') }}</option>
            <option value="other">{{ __('Other') }}</option>
        </flux:select>

        <flux:label>{{ __('Extra') }}</flux:label>
        <flux:error name='extra' />
        <flux:textarea wire:model='extra'></flux:textarea>

        <div class="flex mt-5 gap-3">
            <flux:button variant='primary' type='submit'>{{ __('Send') }}</flux:button>
            <flux:button wire:click="back()">Back</flux:button>
        </div>
    </form>
</div>
