<?php

namespace App\Policies;

use App\Models\User;

class AdminOnlyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isNationalAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
        // National Admin can view Regional Admins and Huissiers
        if ($user->isNationalAdmin()) {
            return $model->isRegionalAdmin() || $model->isHuissier();
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isNationalAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
        // National Admin can update Regional Admins and Huissiers
        if ($user->isNationalAdmin()) {
            return $model->isRegionalAdmin() || $model->isHuissier();
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
        
        if ($user->isNationalAdmin()) {
            return $model->isRegionalAdmin() || $model->isHuissier();
        }

        return false;
    }
}
