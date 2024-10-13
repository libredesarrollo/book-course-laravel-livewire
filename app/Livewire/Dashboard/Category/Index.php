<?php

namespace App\Livewire\Dashboard\Category;

use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Component;

use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $confirmingDeleteCategory;
    public $categoryToDelete;

    function selectCategoryToDelete(Category $category)
    {
        $this->confirmingDeleteCategory = true;
        $this->categoryToDelete = $category;
    }


    // function getCategoryProperty()
    #[Computed()]
    function category()
    {
        sleep(1);
        return time();
        
    }
    function getTime()
    {
        sleep(1);
        return time();
        
    }

    public function render()
    {
        $categories = Category::paginate(2);
        return view('livewire.dashboard.category.index', compact('categories'));
    }

    function delete(/*Category $category*/)
    {
        $this->categoryToDelete->delete();
        $this->confirmingDeleteCategory = false;
        $this->dispatch('deleted');
    }
}
