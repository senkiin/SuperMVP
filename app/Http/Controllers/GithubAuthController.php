<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            $user = User::where('github_id', $githubUser->id)->first();

            if ($user) {
                Auth::login($user);
                return redirect()->intended('dashboard');
            }

            // El email de GitHub puede ser nulo, así que lo verificamos
            $userEmail = $githubUser->getEmail();
            if (!$userEmail) {
                return redirect('/login')->with('error', 'No se pudo obtener tu dirección de email de GitHub. Por favor, asegúrate de que tu email es público en tu perfil de GitHub.');
            }

            $user = User::where('email', $userEmail)->first();

            if ($user) {
                // Vincula la cuenta de GitHub al usuario existente
                $user->update(['github_id' => $githubUser->id]);
            } else {
                // Crea un nuevo usuario
                $user = User::create([
                    'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                    'email' => $userEmail,
                    'github_id' => $githubUser->getId(),
                    'avatar' => $githubUser->getAvatar(),
                    'password' => null,
                ]);
            }

            Auth::login($user);
            return redirect()->intended('dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Algo salió mal con el inicio de sesión de GitHub.');
        }
    }
}
