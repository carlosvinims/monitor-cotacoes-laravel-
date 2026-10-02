<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(loginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if(!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'E-mail ou senha inválidos.',])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('assets.index'))->with('success', 'Login realizado com sucesso.');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('assets.index')->with('success', 'Conta criada com sucesso.');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenarateToken();

        retunr redirect()->route('login')->with('success', 'Logout realizado com sucesso.');
    }
}
