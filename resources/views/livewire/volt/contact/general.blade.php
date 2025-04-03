<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\{Layout};

use App\Models\ContactGeneral;

new
#[Layout('layouts.contact')]
class extends Component {
    #[Validate('required|min:2|max:255')]
    public $subject;

    #[Validate('required')]
    public $type;

    #[Validate('required|min:2')]
    public $message;

    public $step = 1;

    public $pk;
    public $contactGeneral;

    protected $listeners = ['stepEvent'];

    function mount(?int $id = null, ?int $step = null, string $subject = '')
    {
        $this->subject = $subject;
        if ($id != null) {
            $this->contactGeneral = ContactGeneral::findOrFail($id);
            $this->subject = $this->contactGeneral->subject;
            $this->type = $this->contactGeneral->type;
            $this->message = $this->contactGeneral->message;
            $this->pk = $this->contactGeneral->id;

            if ($step) {
                if ($this->type == 'company') {
                    $this->step = 2;
                } elseif ($this->type == 'person') {
                    $this->step = 2.5;
                }
            }
        }
    }

    function stepEvent(/*int*/ $step)
    {
        $this->step = $step;

        $this->dispatch('parentId', $this->pk);
        // $this->dispatch('parentId', id:$this->pk);
    }

    // protected $rules = [
    //     'subject' => 'required|min:2|max:255',
    //     'type' => 'required',
    //     'message' => 'required|min:2',
    // ];

    function submit()
    {
        $this->validate();

        if ($this->pk) {
            ContactGeneral::where('id', $this->pk)->update([
                'subject' => $this->subject,
                'type' => $this->type,
                'message' => $this->message,
            ]);
        } else {
            if ($this->contactGeneral) {
                $this->contactGeneral->update([
                    'subject' => $this->subject,
                    'type' => $this->type,
                    'message' => $this->message,
                ]);
            } else {
                $this->pk = ContactGeneral::create([
                    'subject' => $this->subject,
                    'type' => $this->type,
                    'message' => $this->message,
                ])->id;
                //$this->redirectRoute('contact-edit', ['id' => $this->pk, 'step' => 1]);
            }
        }

        if ($this->type == 'company') {
            $this->step = 2;
        } elseif ($this->type == 'person') {
            $this->step = 2.5;
        }
        $this->stepEvent($this->step);
    }
}; ?>

<div>
    <div class="flex" x-data="{ active: $wire.entangle('step') }" class="flex flex-col max-w-sm mx-auto">
        <div class="flex mx-auto flex-col sm:flex-row mb-5">
            <div class="step" :class="{ 'active': parseInt(active) == 1 }">
                {{ __('STEP 1') }}
            </div>
            <div class="step" :class="{ 'active': parseInt(active) == 2 }">
                {{ __('STEP 2') }}
            </div>
            <div class="step" :class="{ 'active': parseInt(active) == 3 }">
                {{ __('STEP 3') }}
            </div>
        </div>
    </div>
    <div>
        @if ($step == 1)
            <form wire:submit.prevent='submit' class="flex flex-col max-w-sm mx-auto">
                <flux:label>{{ __('Subject') }}</flux:label>
                <flux:error name='subject' />
                <flux:input type='text' wire:model='subject'  />

                <flux:label>{{ __('Type') }}</flux:label>
                <flux:error name='type' />
                <flux:select wire:model='type'>
                    <option value=""></option>
                    <option value="person">{{ __('Person') }}</option>
                    <option value="company">{{ __('Company') }}</option>
                </flux:select>

                <flux:label>{{ __('Message') }}</flux:label>
                <flux:error name='message' />
                <flux:textarea wire:model='message'></flux:textarea>

                <div class="flex mt-5 gap-3">
                    <flux:button variant='primary' type='submit'>{{ __('Send') }}</flux:button>
                </div>
            </form>
        @elseif ($step == 2)
            @livewire('contact.company', ['parentId' => $pk])
        @elseif ($step == 2.5)
            @livewire('contact.person', ['parentId' => $pk])
        @elseif ($step == 3)
            @livewire('contact.detail', ['parentId' => $pk])
        @else
            END
        @endif
    </div>
</div>

