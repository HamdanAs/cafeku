<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class AdminDashboard extends Component
{
    public $users;
    public $form = [
        'picture' => '',
        'fullName' => '',
        'phone' => '',
        'gender' => '',
        'birthdate' => '',
        'email' => '',
        'fullAddress' => ''
    ];

    public function checkUser($id)
    {
        $user = User::query()->with('person')->find($id);

        $this->form['picture'] = $user->picture;
        $this->form['fullName'] = $user->person->firstname . ' ' . $user->person->lastname ?? 'Belum mengisi data';
        $this->form['phone'] = $user->phone ?? 'Belum mengisi data';
        $this->form['gender'] = $user->person->gender === 'L' ? 'Laki Laki' : ($user->person->gender === 'P' ? 'Perempuan' : null) ?? 'Belum mengisi data';
        $this->form['birthdate'] = $user->picture ?? 'Belum mengisi data';
        $this->form['email'] = $user->email ?? 'Belum mengisi data';
        $this->form['fullAddress'] = $user->person->full_address ?? 'Belum mengisi data';
    }

    public function mount()
    {
        $this->users = User::query()->whereNot('role_id', 2)->latest()->get();
    }

    public function render()
    {
        return view('livewire.admin-dashboard', [
            'activities' => Activity::orderBy('created_at', 'desc')->paginate(5)
        ]);
    }
}
