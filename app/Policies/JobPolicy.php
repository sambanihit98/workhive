<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Employer;
use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{

    // public function show(Employer $employer, Job $job): bool
    // {
    //     return $job->employer_id === $employer->id;
    // }

    // public function edit(Employer $employer, Job $job): bool
    // {
    //     return $job->employer_id === $employer->id;
    // }

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
    public function view($user, Job $job): bool
    {
        return $user instanceof Admin || $user instanceof Employer;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Employer $employer): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Employer $employer, Job $job): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Job $job): bool
    {
        return $user instanceof Admin || $user instanceof Employer;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Employer $employer, Job $job): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Employer $employer, Job $job): bool
    {
        return false;
    }
}
