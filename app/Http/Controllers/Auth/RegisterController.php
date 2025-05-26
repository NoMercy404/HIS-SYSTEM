<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6|confirmed',
            'is_doctor'  => 'accepted'
        ]);

        $user = User::create([
            'first_name'          => $request->first_name,
            'last_name'           => $request->last_name,
            'email'               => $request->email,
            'password'            => Hash::make($request->password),
            'role'                => 'lekarz',
            'password_changed_at' => Carbon::now(),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard'); // Zmień na odpowiedni widok
    }
}
