<?php

namespace App\Policies;

use App\Models\Acte;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isNationalAdmin() || $user->isRegionalAdmin() || $user->isHuissier();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Acte $acte): bool
    {
        if ($user->isSuperAdmin() || $user->isNationalAdmin()) {
            return true;
        }

        if ($user->isRegionalAdmin()) {
            return $acte->huissier->tribunal->region_id === $user->region_id;
        }

        if ($user->isHuissier()) {
            return $acte->huissier_id === $user->huissier_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isHuissier() || $user->isSuperAdmin(); // Usually only Huissiers create acts
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Acte $acte): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isHuissier()) {
            return $acte->huissier_id === $user->huissier_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Acte $acte): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Acte $acte): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Acte $acte): bool
    {
        return $user->isSuperAdmin();
    }
}
