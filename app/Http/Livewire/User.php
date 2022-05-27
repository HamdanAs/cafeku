<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\User as ModelsUser;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class User extends Component
{
    use LivewireAlert;

    public $userId;

    protected $listeners = ['confirmed'];

    public function giveRole($userId)
    {
        $this->userId = $userId;

        $roles = Role::query()->get('name');
        $flattenedRoles = [];

        foreach($roles as $role){
            $flattenedRoles[] = $role->name;
        }

        $user = ModelsUser::query()->find($userId);

        return $this->alert('info', 'Berikan role', [
            'timer' => false,
            'input' => 'select',
            'inputOptions' => $flattenedRoles,
            'inputPlaceholder' => 'Silahkan beri role untuk ' . $user->username,
            'position' => 'center',
            'toast' => false,
            'showCancelButton' => true,
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmed'
        ]);
    }

    public function confirmed($data)
    {
        $roleId = $data['value'] + 1;

        $user = ModelsUser::query()->find($this->userId);

        $user->update(['role_id' => $roleId]);

        return $this->alert('success', "Berhasil memberikan role ". $user->role->name ." kepada $user->username");
    }

    public function render()
    {
        return view('livewire.user', [
            'users' => ModelsUser::query()->with(['person', 'role'])->whereNot('role_id', 2)->get()
        ]);
    }
}
