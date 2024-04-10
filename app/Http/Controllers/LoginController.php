<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;

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
            
            // si identifiants ok, on commence par régénérer la session pour éviter la "fixation de session"
            // il s'agit du vol de l'identifiant de session par une tierce personne
            // https://fr.wikipedia.org/wiki/Fixation_de_session
            $request->session()->regenerate();

            // si la connexion fonctionne, on récupère l'utilisateur et on charge son rôle
            $authUser = User::find(Auth::user()->id)->load('role');

            // on renvoie la réponse 
            return response()->json([$authUser, 'Vous êtes connecté']);
        } else {
            // si échec de la connexion, on renvoie un message d'erreur
            return response()->json(['Echec de la connexion.', 'errors' => 'L\'utilisateur n\'existe pas ou le mot de passe est incorrect']);
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
        // déconnecte de la session en cours
        Auth::guard('web')->logout();

        // // supprime la session en cours
        // $request->session()->invalidate();

        // // régénère la valeur du cookie CSRF de la session
        // $request->session()->regenerateToken();

        return response()->json([
            'status' => true,
            'message' => 'Déconnexion réussie'
        ]);
    }
}

