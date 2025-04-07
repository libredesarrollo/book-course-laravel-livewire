<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PostForm extends Form
{

    #[Validate('required|min:2|max:255')]
    public $title = '';
    
    #[Validate('required')]
    public $date = '';
    
    #[Validate('required')]
    public $category_id = '';
    
    #[Validate('required')]
    public $posted = '';

    #[Validate('required')]
    public $type = '';
    
    #[Validate('required|min:2|max:5000')]
    public $text = '';

    #[Validate('required|min:2|max:255')]
    public $description = '';

    #[Validate('nullable|image|max:1024')]
    public $image = '';
    

    //
}
