<?php

namespace App\Livewire\Dashboard\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

use Livewire\WithFileUploads;

class Save extends Component
{

    use WithFileUploads;

    public $title;
    public $slug;
    public $text;
    public $image;

    protected $rules = [
        'title' => "required|min:2|max:255",
        'text' => "nullable",
        'image' => "nullable|image|max:1024",
    ];

    public $category;

    public function mount(?int $id = null)
    {
        if ($id != null) {
            $this->category = Category::findOrFail($id);
            $this->title = $this->category->title;
            $this->text = $this->category->text;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.category.save');
    }

    function submit()
    {
        // validate
        $this->validate();

        if ($this->category) {
            $this->category->update([
                'title' => $this->title,
                'text' => $this->text,
            ]);
            $this->dispatch("updated");
        } else {

            $this->category = Category::create([
                'title' => $this->title,
                'slug' => str($this->title)->slug(),
                'text' => $this->text,
            ]);
            $this->dispatch("created");
        }

        // upload
        if ($this->image) {
            // delete old img
            if ($this->category->image) {
                Storage::disk('public_upload')
                    ->delete('images/category/' . $this->category->image);
            }


            $imageName = $this->category->slug . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('images/category', $imageName, 'public_upload');


            $this->category->update([
                'image' => $imageName
            ]);
        }
    }
}
