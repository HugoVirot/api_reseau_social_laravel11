<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // vérification : si le user est admin => je peux tout faire
    public function before(User $user): bool
    {
        // la meilleure syntaxe
        return $user->isAdmin();
        // syntaxe plus facile à comprendre
        // if ($user->isAdmin()) {
        //     return true;
        // } else {
        //     return false;
        // }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id == $post->user_id; // seul le user peut modifier son message (ou l'admin)
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id == $post->user_id; // seul le user peut modifier son message (ou l'admin)
    }
}
