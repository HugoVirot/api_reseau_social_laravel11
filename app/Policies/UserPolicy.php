<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->role == "admin"; // seul l'admin peut voir la liste des users
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->id == $model->id; // seul le user peut modifier son propre profil
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    { 
        return $user->id == $model->id || $user->role->role == "admin";  //seul le user peut sspprimer son compte (ou l'admin)
    }
}
