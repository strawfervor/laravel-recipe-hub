<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return true;
        }

        throw ValidationException::withMessages([
            'email' => 'Nieprawidłowy email lub hasło.',
        ]);
    }

    public function register(array $data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        Auth::login($user);
        return $user;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}
