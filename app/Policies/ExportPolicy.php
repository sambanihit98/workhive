<?php

namespace App\Policies;

use App\Models\Admin;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Contracts\Auth\Authenticatable;

class ExportPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(Authenticatable $user, Export $export): bool
    {
        return $export->user()->is($user);
    }
}
