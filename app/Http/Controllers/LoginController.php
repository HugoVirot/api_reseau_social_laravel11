<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Tenter la connexion utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Laravel tente de connecter le user si l'email existe ET si le mdp en clair correspond à celui hashé 
        if (Auth::attempt($credentials)) {
            // forcer la régénération du token csrf
            //https://laracasts.com/discuss/channels/laravel/is-it-really-necessary-to-call-session-regenerate-after-login
            $request->session()->regenerate();
            // si la connexion fonctionne, on renvoie la réponse contenant le user connecté 
            return response()->json([
                'status' => true,
                'message' => 'Vous êtes connecté',
                'user' => Auth::user()
            ]);
        } else {
            // si échec de la connexion, on renvoie un message d'erreur
            return response()->json([
                'status' => false,
                'message' => 'Echec de la connexion.',
                'errors' => ['L\'utilisateur n\'existe pas ou le mot de passe est incorrect']
            ], 401);
        }
    }

    /**
     * Tenter la connexion utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        //dd($request);
        // déconnecte de la session en cours et invalide le token du cookie de session
        Auth::guard('web')->logout();

        return response()->json([
            'status' => true,
            'message' => 'Déconnexion réussie'
        ]);
    }
}
