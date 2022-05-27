<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class Login extends Component
{
    use Actions;

    public $form = [
        'email' => '',
        'password' => ''
    ];

    protected $rules = [
        'form.email' => 'required|email',
        'form.password' => 'required'
    ];

    protected $messages = [
        'form.email.required' => 'Email harus diisi.',
        'form.email.email' => 'Format email salah.',
        'form.password.required' => 'Password harus diisi.',
    ];

    public function login()
    {
        $this->validate();

        if (!Auth::attempt($this->form)) {
            return $this->dialog()->error(
                'Login Gagal!',
                'Silahkan cek kembali email dan password anda.'
            );
        }

        if (Auth::user()->role->id === 1) {
            return $this->dialog()->error(
                'Login Gagal!',
                'Anda masih belum memiliki role! Silahkan hubungi admin!'
            );
        }

        switch (Auth::user()->role->id) {
            case 2:
                return redirect(route('admin.dashboard'))->with('success', 'Login berhasil!');
                break;

            case 3:
                return redirect(route('manager.dashboard'))->with('success', 'Login berhasil!');
                break;

            case 4:
                return redirect(route('cashier.dashboard'))->with('success', 'Login berhasil!');
                break;

            default:
                return redirect()->back()->with('error', 'Anda belum bisa login!');
                break;
        }
    }

    public function render()
    {
        return view('livewire.login');
    }
}
