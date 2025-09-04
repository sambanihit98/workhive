<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmployerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user instanceof Admin || $user instanceof User;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Employer $employer): bool
    {
        return $user instanceof Admin || $user instanceof User;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Employer $employer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Employer $employer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Employer $employer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Employer $employer): bool
    {
        return false;
    }
}
