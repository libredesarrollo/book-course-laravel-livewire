<?php

namespace App\Livewire\Contact;

use App\Models\ContactCompany;
use Livewire\Component;

#[Layout('layouts.contact')]
class Company extends Component
{
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
        if($c != null){
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
            ['contact_general_id' => $this->parentId]
            ,
            [
                'name' => $this->name,
                'identification' => $this->identification,
                'email' => $this->email,
                'extra' => $this->extra,
                'choices' => $this->choices,
                'contact_general_id' => $this->parentId
            ]
        );

        $this->dispatch('stepEvent', 3);

    }

    function back() {
        $this->dispatch('stepEvent', 1);
    }
}
