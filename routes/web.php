<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Carbon;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;

Route::view('/', 'welcome')->name('home');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/dashboard', function () {
    $user = Auth::user();
    $changedAt = $user->password_changed_at;
    $daysLeft = null;

    if ($changedAt) {
        $daysLeft = round(30 - $changedAt->diffInDays(now()));
    }

    return view('dashboard', [
        'user' => $user,
        'daysLeft' => $daysLeft,
    ]);
})->middleware('auth')->name('dashboard');


Route::get('/password/change', function () {
    return view('auth.change-password');
})->middleware('auth')->name('password.change.form');


Route::post('/password/change', function (Request $request) {
    $request->validate([
        'current_password' => ['required', 'current_password'],
        'new_password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $user = $request->user();
    $user->password = Hash::make($request->new_password);
    $user->password_changed_at = now();
    $user->save();

    return redirect()->route('password.change.form')->with('status', 'Hasło zostało zmienione.');
})->middleware('auth')->name('password.change');

Route::get('/wizyty', function () {
    $visits = Visit::orderBy('visit_date', 'asc')->get();
    return view('visits', compact('visits'));
})->middleware('auth')->name('visits.index');

Route::get('/visits/my', function () {
    $visits = Visit::where('doctor_id', Auth::id())->get();

    return view('visits.my', [
        'visits' => $visits,
    ]);
})->middleware('auth')->name('visits.my');
