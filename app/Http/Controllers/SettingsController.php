<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        ], [
            'new_password.regex' => 'La contraseña debe tener letras (mayúsculas/minúsculas), números y caracteres especiales.',
            'new_password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Contraseña cambiada exitosamente.');
    }

    public function updateLanguage(Request $request)
    {
        $validated = $request->validate([
            'locale' => 'required|in:es,en',
        ]);
        
        session(['locale' => $validated['locale']]);
        
        // This success message won't translate because validation translates implicitly or via manual __() calls.
        // We'll leave it simple for now.
        return redirect()->back()->with('success', __('Idioma actualizado correctamente.'));
    }
}
