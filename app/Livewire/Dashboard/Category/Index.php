<?php

namespace App\Livewire\Dashboard\Category;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Category;
use Flux\Flux;

class Index extends Component
{
    use WithPagination;

    public $categoryToDelete;

    public function render()
    {
        $categories = Category::paginate(10);
    
        return view('livewire.dashboard.category.index', compact('categories'));
    }

    function selectCategoryToDelete(Category $category){
        $this->categoryToDelete = $category;
    }

    function delete(){
        $this->dispatch("deleted");
        Flux::modal("delete-category")->close();
        $this->categoryToDelete->delete();
    }

    // function delete(Category $category){
    //     $this->dispatch("deleted");
    //     $category->delete();
    // }
}
