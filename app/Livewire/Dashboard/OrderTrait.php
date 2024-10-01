<?php
namespace App\Livewire\Dashboard;

trait OrderTrait
{
    public $sortColumn = 'id';
    public $sortDirection = 'desc';

    function sort($column)
    {
        $this->sortColumn = $column;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }


}