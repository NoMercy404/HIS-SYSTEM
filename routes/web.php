<?php

use App\Models\Patients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Visit;
use Illuminate\Support\Carbon;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\VisitController;

Route::view('/', 'welcome')->name('home');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('research', ResearchController::class);
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

    return redirect()->route('dashboard')->with('status', 'Hasło zostało zmienione.');
})->middleware('auth')->name('password.change');

Route::get('/wizyty', function (Request $request) {
    $filter = $request->query('filter');
    $doctorId = $request->query('doctor_id');

    $query = Visit::with(['patient', 'doctor']);

    if ($filter === 'mine') {
        $query->where('doctor_id', Auth::id());
    } elseif ($filter === 'today') {
        $query->whereDate('visit_date', Carbon::today());
    }

    if ($doctorId) {
        $query->where('doctor_id', $doctorId);
    }

    $visits = $query->orderBy('visit_date','desc')->get();
    $doctors = User::where('role', 'lekarz')
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();


    return view('visits', compact('visits', 'doctors'));
})->middleware('auth')->name('visits.index');

Route::get('/visits/my', function () {
    $visits = Visit::where('doctor_id', Auth::id())->get();

    return view('visits.my', [
        'visits' => $visits,
    ]);
})->middleware('auth')->name('visits.my');


Route::get('/patients', function (Request $request) {
    $query = Patients::query();

    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
                ->orWhere('PESEL', 'like', "%$search%");
        });
    }

    if ($request->has('on_ward')) {
        $query->where('is_on_ward', true);
    }

    $patients = $query->orderBy('last_name')->get();

    return view('patients', [
        'patients' => $patients,
        'search' => $search
    ]);
})->name('patients.index');

Route::get('/patients/{id}/history', [PatientsController::class, 'history'])->name('patients.history');

Route::get('/patients/{patient}/edit', [PatientsController::class, 'edit'])->name('patients.edit');
Route::put('/patients/{patient}', [PatientsController::class, 'update'])->name('patients.update');
Route::delete('/patients/{patient}', [PatientsController::class, 'destroy'])->name('patients.destroy');

Route::get('/patients/{id}', [PatientsController::class, 'show'])->where('id', '[0-9]+')->name('patients.show');
Route::delete('/visits/{id}', [VisitController::class, 'destroy'])->name('visits.destroy');
Route::put('/visits/{id}/reschedule', [VisitController::class, 'reschedule'])->name('visits.reschedule');
Route::get('/visits/{id}/edit', [VisitController::class, 'edit'])->name('visits.edit');
Route::put('/visits/{id}', [VisitController::class, 'update'])->name('visits.update');
Route::get('/visits/create', [VisitController::class, 'create'])->name('visits.create');
Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');

Route::get('/patients', [PatientsController::class, 'index'])->name('patients.index');
Route::get('/patients/create', [PatientsController::class, 'create'])->name('patients.create');

Route::resource('patients', PatientsController::class);
Route::resource('research', ResearchController::class);
Route::get('/research/{id}/complete', [ResearchController::class, 'completeForm'])->name('research.complete.form');
Route::put('/research/{id}/complete', [ResearchController::class, 'complete'])->name('research.complete');
Route::put('/research/{id}/cancel', [ResearchController::class, 'cancel'])->name('research.cancel');

