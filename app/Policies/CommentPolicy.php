<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id == $comment->user_id || $user->role->role == "admin"; // seul le user peut modifier son message (ou l'admin)
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
       // autorisés à supprimer le commentaire : son auteur, l'auteur du post associé et l'admin
        return $user->id == $comment->user_id ||$user->id == $comment->post->user_id || $user->role->role == "admin"; 
    }
}
