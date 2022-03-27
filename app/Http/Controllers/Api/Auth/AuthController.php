<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Models\User;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    private AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService;
    }

    public function save(RegisterUserRequest $request)
    {
        $data = $request->only('username', 'email', 'password', 'password_confirmation');

        $user = $this->service->storeUser($data);

        activity()->by($user)->log('Mendaftarkan akun baru');

        return $this->sendResponse($user);
    }

    public function auth(LoginRequest $request)
    {
        $token = $this->service->check($request->only('email', 'password'));

        if ($token->error) {
            return $this->sendError($token->result, 404, "Login gagal");
        }

        activity()->by(Auth::user())->log('Login');

        return $this->sendResponse($token->result, 200, "Login berhasil!");
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        activity()->by(Auth::user())->log('Logout');

        return $this->sendResponse("Berhasil Logout");
    }
}
