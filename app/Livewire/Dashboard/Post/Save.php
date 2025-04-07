<?php

namespace App\Livewire\Dashboard\Post;

use App\Livewire\Forms\PostForm;
use Livewire\Attributes\Locked;
use Livewire\Component;

use App\Models\Category;
use App\Models\Post;

class Save extends Component
{

    // public $title;
    // public $description;
    // public $text;
    // public $type;
    // public $posted;
    // public $category_id;
    // public $image;
    // public $date;

    public $post;
    public PostForm $form;

    #[Locked]
    public $id;
    // private $id;

    public function render()
    {
        $categories = Category::get();
        return view('livewire.dashboard.post.save', compact('categories'));
    }

    // protected $rules = [
    //     'title' => 'required|min:2|max:255',
    //     'description' => 'required|min:2|max:255',
    //     'date' => 'required',
    //     'category_id' => 'required',
    //     'posted' => 'required',
    //     'text' => 'required|min:2|max:5000',
    //     'image' => 'nullable|image|max:1024'
    // ];

    function mount(?int $id = null)
    {
        if ($id != null) {
            $this->id = $id;
            $this->post = Post::findOrFail($id);
            $this->form->text = $this->post->text;
            $this->form->title = $this->post->title;
            $this->form->category_id = $this->post->category_id;
            $this->form->posted = $this->post->posted;
            $this->form->type = $this->post->type;
            $this->form->description = $this->post->description;
            $this->form->date = $this->post->date;
        }
    }

    function submit(/*$content*/)
    {
        // dd($this->form->all()['title']);
        $this->validate();
        // dd($this->form->only(['title']));
        // dd($content);
        
        // dd($this->id);
        if ($this->post) {
            $this->post->update($this->form->all());
            //     [
            //         'title' => $this->title,
            //         'text' => $this->text,
            //         'description' => $this->description,
            //         'category_id' => $this->category_id,
            //         'date' => $this->date,
            //         'type' => $this->type,
            //         'posted' => $this->posted,
            //         'slug' => str($this->title)->slug(),
            //     ]
            // );
            $this->dispatch('updated');
        } else {
            $this->post = Post::create($this->form->all());
                // [
                    // 'title' => $this->title,
                    // 'text' => $this->text,
                    // 'description' => $this->description,
                    // 'category_id' => $this->category_id,
                    // 'date' => $this->date,
                    // 'type' => $this->type,
                    // 'posted' => $this->posted,
                    // 'slug' => str($this->title)->slug(),
                // ]
            
            $this->dispatch('created');
        }

        // upload
        if ($this->form->image) {
            $imageName = $this->post->slug . '.' . $this->form->image->getClientOriginalExtension();
            $this->form->image->storeAs('images/post', $imageName, 'public_upload');

            $this->post->update([
                'image' => $imageName
            ]);
        }
    }
}
