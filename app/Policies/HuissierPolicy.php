<?php

namespace App\Policies;

use App\Models\Huissier;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HuissierPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isNationalAdmin() || $user->isRegionalAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Huissier $huissier): bool
    {
        if ($user->isSuperAdmin() || $user->isNationalAdmin()) {
            return true;
        }

        if ($user->isRegionalAdmin()) {
            return $huissier->tribunal->region_id === $user->region_id;
        }

        // A Huissier can view their own profile
        return $user->isHuissier() && $user->huissier_id === $huissier->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isNationalAdmin() || $user->isRegionalAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Huissier $huissier): bool
    {
        if ($user->isSuperAdmin() || $user->isNationalAdmin()) {
            return true;
        }

        if ($user->isRegionalAdmin()) {
            return $huissier->tribunal->region_id === $user->region_id;
        }

        // A Huissier can update their own profile
        return $user->isHuissier() && $user->huissier_id === $huissier->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Huissier $huissier): bool
    {
        return $user->isSuperAdmin() || $user->isNationalAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Huissier $huissier): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Huissier $huissier): bool
    {
        return $user->isSuperAdmin();
    }
}
