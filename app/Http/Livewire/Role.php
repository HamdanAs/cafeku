<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Role extends Component
{
    public $userId;
    public $isOpen;

    public function mount($userId)
    {
        $this->userId = $userId;

        if($this->userId){
            $this->isOpen = true;
        }

        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.role');
    }
}
