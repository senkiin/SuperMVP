<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirige al usuario a la página de autenticación de Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtiene la información del usuario de Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Busca si el usuario ya existe con ese google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                // Si existe, inicia sesión
                Auth::login($user);
                return redirect()->intended('dashboard');
            }

            // Si no existe, comprueba si hay un usuario con ese email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Si existe un usuario con ese email, actualiza su google_id
                $user->update(['google_id' => $googleUser->getId()]);
            } else {
                // Si no existe, crea un nuevo usuario
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => null, // O puedes generar una contraseña aleatoria
                ]);
            }

            Auth::login($user);
            return redirect()->intended('dashboard');

        } catch (\Exception $e) {
            // Puedes registrar el error si lo deseas
            // Log::error($e->getMessage());
            return redirect('/login')->with('error', 'Algo salió mal con el inicio de sesión de Google.');
        }
    }
}
