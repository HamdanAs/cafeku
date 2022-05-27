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

    protected $messages = [
        'form.username.required' => 'Username harus diisi.',
        'form.username.unique' => 'Username sudah terdaftar.',
        'form.email.required' => 'Email harus diisi.',
        'form.email.unique' => 'Email sudah terdaftar.',
        'form.email.email' => 'Format email salah.',
        'form.password.required' => 'Password harus diisi.',
        'form.password.confirmed' => 'Konfirmasi password salah.'
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'username' => $this->form['username'],
            'email' => $this->form['email'],
            'password' => Hash::make($this->form['password']),
            'role_id' => 1
        ]);

        $user->person()->create();

        return redirect(route('login'))->with('success', 'Registrasi berhasil!');
    }

    public function render()
    {
        return view('livewire.register');
    }
}
