<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $findUser = User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

            if ($findUser) {
                Auth::login($findUser, true); // Activar "recordarme"
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'lastname' => $googleUser->user['family_name'] ?? 'N/A',
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => encrypt('12345678'), // Puedes cambiar esto
                ]);
                Auth::login($user, true); // Activar "recordarme"
            }

            return redirect('/'); // Cambia esto a la ruta que quieras redirigir después del login
            
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'No se pudo autenticar con Google, intente de nuevo.');
        }
    }
}

