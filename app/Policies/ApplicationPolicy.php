<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Application;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user instanceof Admin || $user instanceof Employer;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Application $application): bool
    {
        return $user instanceof Admin || $user instanceof Employer;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Employer $employer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Employer $employer, Application $application): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Employer $employer, Application $application): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Application $application): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Application $application): bool
    {
        return false;
    }
}
