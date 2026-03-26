<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('create-user');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('send_credentials')) {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\UserCredentialsMail($user, $request->password));
        }

        return redirect()->route('users.create')->with('success', 'Usuario creado exitosamente. Ya puede iniciar sesión en el sistema.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->email === 'edy.omar2005@gmail.com') {
            return back()->with('error', 'No puedes eliminar al administrador principal del sistema.');
        }

        // Prevent deleting current user
        if (auth()->id() === $user->id) {
            return back()->with('error', 'No puedes eliminar tu propio usuario mientras estás en sesión.');
        }

        $user->delete();

        return back()->with('success', 'Usuario eliminado correctamente del sistema NexusHub.');
    }
}
