<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Employer extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\EmployerFactory> */
    use HasFactory;
    use Notifiable;

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'logo',
    //     // add any other fields you need
    // ];

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function employer_address()
    {
        return $this->hasOne(EmployerAddress::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true; //access panel in production
    }

    // public function getFilamentName(): string
    // {
    //     return $this->name ?? 'Employer';
    // }


    //to access the application model through job model
    // public function application()
    // {
    //     return $this->hasManyThrough(
    //         Application::class, // Final model
    //         Job::class,         // Intermediate model
    //         'employer_id',      // Foreign key on Job
    //         'job_id',           // Foreign key on Application
    //         'id',               // Local key on Employer
    //         'id'                // Local key on Job
    //     );
    // }
}
