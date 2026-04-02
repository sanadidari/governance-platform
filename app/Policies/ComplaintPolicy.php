<?php

namespace App\Policies;

use App\Models\Complaint;
use App\Models\User;

class ComplaintPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isNationalAdmin() || $user->isHuissier();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Complaint $complaint): bool
    {
        if ($user->isSuperAdmin() || $user->isNationalAdmin()) {
            return true;
        }
        // Huissier can only view their own
        return $user->isHuissier() && $user->huissier_id === $complaint->huissier_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isHuissier() || $user->isSuperAdmin(); // Usually only Huissiers complain, but admins can test
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Complaint $complaint): bool
    {
        if ($user->isSuperAdmin() || $user->isNationalAdmin()) {
            return true; // Admins update status/notes
        }
        return false; // Huissiers cannot edit a sent complaint (integrity)
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Complaint $complaint): bool
    {
        return $user->isSuperAdmin();
    }
}
