<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $form = [
        'email' => '',
        'password' => ''
    ];

    protected $rules = [
        'form.email' => 'required|email',
        'form.password' => 'required'
    ];

    public function login()
    {
        $this->validate();

        if(!Auth::attempt($this->form)){
            return redirect()->back()->with('error', 'Login gagal! email atau password mungkin salah!');
        }

        switch (Auth::user()->role->id) {
            case 1:
                return redirect(route('admin.dashboard'))->with('success', 'Login berhasil!');
                break;

            case 2:
                return redirect(route('manager.dashboard'))->with('success', 'Login berhasil!');
                break;

            case 3:
                return redirect(route('cashier.dashboard'))->with('success', 'Login berhasil!');
                break;

            case null:
                return redirect()->back()->with('error', 'Anda belum memiliki role!');
                break;
            default:
                return redirect()->back()->with('error', 'Anda belum memiliki role!');
                break;
        }
    }

    public function render()
    {
        return view('livewire.login');
    }
}
