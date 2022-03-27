<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    public function all(Request $request)
    {
        return $this->sendResponse(Role::all());
    }
}
