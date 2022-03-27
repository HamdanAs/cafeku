<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Api\BaseController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function giveRole(Request $request, User $user){
        $validated = $request->validate([
            'role' => 'required'
        ]);

        $user->update([
            'role_id' => $validated['role']
        ]);

        activity()->by(Auth::user())->on(new Role())->log('Giving role to ' . $user->username);

        return $this->sendResponse($user);
    }
}
