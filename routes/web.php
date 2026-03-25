<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

// Middleware-like check for session
$authCheck = function () {
    if (!Session::has('logged_in')) {
        return redirect()->route('login');
    }
};

use Illuminate\Support\Facades\Auth;

// Entry point: If logged in, go to dashboard.
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('login');
})->name('root');

use App\Models\Website;

use App\Http\Controllers\WebsiteController;

use App\Http\Controllers\SettingsController;

// Dashboard route: Protected
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('root');
    }
    $websites = App\Models\Website::all();
    return view('dashboard', compact('websites'));
})->name('dashboard');

// Settings routes
Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
Route::post('/settings/language', [SettingsController::class, 'updateLanguage'])->name('settings.language.update');

// Website CRUD
Route::post('/websites', [WebsiteController::class, 'store'])->name('websites.store');
Route::put('/websites/{website}', [WebsiteController::class, 'update'])->name('websites.update');
Route::delete('/websites/{website}', [WebsiteController::class, 'destroy'])->name('websites.destroy');

// User Management (Protected)
use App\Http\Controllers\UserController;
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Login GET route (redirect to root)
Route::get('/login', function () {
    return redirect()->route('root');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'message' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    ])->onlyInput('email');
})->name('login.post');

use App\Http\Controllers\PasswordResetController;
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request')->middleware('guest');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('guest');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset')->middleware('guest');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update')->middleware('guest');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('root');
})->name('logout');
