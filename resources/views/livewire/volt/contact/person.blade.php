<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

use App\Models\ContactPerson;

new class extends Component {
    {

    public $name;
    public $surname;
    public $choices;
    public $other;

    protected $rules = [
        'name' => 'required|min:2|max:255',
        'surname' => 'required|min:2|max:255',
        'choices' => 'required',
        'other' => 'nullable',
    ];

    public $parentId;

    protected $listeners = ['parentId'];

    // ****
    function mount($parentId)
    {
        $this->parentId($parentId);
    }

    // **** #[On('parentId')] 
    function parentId($id)
    {
        $this->parentId = $id;

        $c = ContactPerson::where('contact_general_id', $this->parentId)->first();
        if ($c != null) {
            $this->name = $c->name;
            $this->surname = $c->surname;
            $this->other = $c->other;
            $this->choices = $c->choices;
        }
    }

    function submit()
    {
        $this->validate();
        ContactPerson::updateOrCreate(
            ['contact_general_id' => $this->parentId]
            ,
            [
                'name' => $this->name,
                'surname' => $this->surname,
                'choices' => $this->choices,
                'contact_general_id' => $this->parentId,
                'other' => $this->other,
            ]
        );

        $this->dispatch('stepEvent', 3);
    }

    function back() {
        $this->dispatch('stepEvent', 1);
    }

}; ?>

<div>
    <form wire:submit.prevent='submit' class="flex flex-col max-w-sm mx-auto">
        <flux:label>{{ __('Name') }}</flux:label>
        <flux:error name='name' />
        <x-input type='text' wire:model='name' />

        <flux:label>{{ __('Surname') }}</flux:label>
        <flux:error name='surname' />
        <x-input type='text' wire:model='surname' />

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

        <flux:label>{{ __('Other') }}</flux:label>
        <flux:error name='other' />
        <flux:textarea variant='primary' wire:model='other'></flux:textarea>

        <div class="flex mt-5 gap-3">
            <x-button variant='primary' type='submit'>{{ __('Send') }}</x-button>
            <x-button wire:click="back()">Back</x-button>
        </div>
    </form>
</div>
