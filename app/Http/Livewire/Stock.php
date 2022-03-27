<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Stock extends Component
{
    public $stock;

    public function render()
    {
        return view('livewire.stock');
    }
}
