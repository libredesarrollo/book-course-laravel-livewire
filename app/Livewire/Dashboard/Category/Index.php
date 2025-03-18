<?php

namespace App\Livewire\Dashboard\Category;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Category;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $categories = Category::paginate(10);
    
        return view('livewire.dashboard.category.index', compact('categories'));
    }

    function delete(Category $category){
        $this->dispatch("deleted");
        $category->delete();
    }
}
