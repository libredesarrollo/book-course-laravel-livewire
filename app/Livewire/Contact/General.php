<?php

namespace App\Livewire\Contact;

use App\Models\ContactGeneral;
use Livewire\Attributes\Validate;
use Livewire\Component;

class General extends Component
{

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

    function mount(?int $id = null, ?int $step = null)
    {
        if ($id != null) {
            $this->contactGeneral = ContactGeneral::findOrFail($id);
            $this->subject = $this->contactGeneral->subject;
            $this->type = $this->contactGeneral->type;
            $this->message = $this->contactGeneral->message;
            $this->pk = $this->contactGeneral->id;

            if ($step) {
                if ($this->type == 'company') {
                    $this->step = 2;
                } else if ($this->type == 'person') {
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

    public function render()
    {
        return view('livewire.contact.general')->layout('layouts.contact');
    }

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
                $this->contactGeneral->update(
                    [
                        'subject' => $this->subject,
                        'type' => $this->type,
                        'message' => $this->message,
                    ]
                );
            } else {
                $this->pk = ContactGeneral::create([
                    'subject' => $this->subject,
                    'type' => $this->type,
                    'message' => $this->message,
                ])->id;
                $this->redirectRoute('contact-edit', ['id' => $this->pk, 'step' => 1]);
            }
        }

        if ($this->type == 'company') {
            $this->step = 2;
        } else if ($this->type == 'person') {
            $this->step = 2.5;
        }
        $this->stepEvent($this->step);


    }
}
