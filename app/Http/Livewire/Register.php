<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $form = [
        'username' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => ''
    ];

    protected $rules = [
        'form.username' => 'required|unique:users,username',
        'form.email' => 'required|email|unique:users,email',
        'form.password' => 'required|confirmed'
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'username' => $this->form['username'],
            'email' => $this->form['email'],
            'password' => Hash::make($this->form['password'])
        ]);

        $user->person()->create();

        return redirect(route('login'))->with('success', 'Registrasi berhasil!');
    }

    public function render()
    {
        return view('livewire.register');
    }
}
