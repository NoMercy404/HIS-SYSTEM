<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if (!$user->password_changed_at || $user->password_changed_at->diffInDays(now()) > 30) {
                return redirect()->route('password.change.form')
                    ->with('status', 'Twoje hasło jest przestarzałe. Zmień je, aby kontynuować.');
            }

            return redirect()->intended('dashboard');
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', 'Nieprawidłowy email lub hasło.');

    }


//    public function register(Request $request)
//    {
//        $request->validate([
//            'firstname' => 'required|string',
//            'lastname' => 'required|string',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|confirmed|min:6',
//        ]);
//
//        User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//        ]);
//
//        return redirect()->route('login')->with('success', 'Rejestracja zakończona sukcesem!');
//    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
