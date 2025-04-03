<?php

use Livewire\Volt\Component;

use App\Models\ContactDetail;
use App\Models\ContactGeneral;

use Livewire\Attributes\Validate;

new class extends Component {
    #[Validate('required|min:2|max:500')]
    public $extra;

    public $parentId;

    protected $listeners = ['parentId'];

    function mount($parentId)
    {
        $this->parentId($parentId);
    }

    function parentId($parentId)
    {
        $this->parentId = $parentId;

        $c = ContactDetail::where('contact_general_id', $this->parentId)->first();
        if ($c != null) {
            $this->extra = $c->extra;
        }
    }
    public function render()
    {
        return view('livewire.contact.detail');
    }

    function submit()
    {
        $this->validate();

        ContactDetail::updateOrCreate(
            ['contact_general_id' => $this->parentId],
            [
                'extra' => $this->extra,
                'contact_general_id' => $this->parentId,
            ],
        );

        $this->dispatch('stepEvent', 4);
    }

    function back()
    {
        $contactGeneral = ContactGeneral::find($this->parentId);

        if ($contactGeneral->type == 'company') {
            $this->dispatch('stepEvent', 2);
        } elseif ($contactGeneral->type == 'person') {
            $this->dispatch('stepEvent', 2.5);
        }
    }
}; ?>

<div>
    <form wire:submit.prevent='submit' class="flex flex-col max-w-sm mx-auto">
        <flux:label>{{ __('Extra') }}</flux:label>
        <flux:error name='extra' />
        <flux:textarea wire:model='extra'></flux:textarea>

        <div class="flex mt-5 gap-3">
            <x-button variant='primary' type='submit'>{{ __('Send') }}</x-button>
            <x-button wire:click="back()">Back</x-button>
        </div>
    </form>
</div>
