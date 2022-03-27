<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class AdminDashboard extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::query()->latest()->get();
    }

    public function render()
    {
        return view('livewire.admin-dashboard', [
            'activities' => Activity::paginate(5)
        ]);
    }
}
