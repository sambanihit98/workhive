<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function user_address()
    {
        return $this->hasOne(UserAddress::class);
    }

    public function application()
    {
        return $this->hasMany(Application::class);
    }

    public function work_experience()
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function getFullNameAttribute()
    {

        $first_name   = $this->first_name;
        $middle_name  = $this->middle_name;
        $last_name    = $this->last_name;

        if (!$middle_name) {
            $full_name = $first_name . ' ' . $last_name;
        } else {
            $middle_initial = substr($middle_name, 0, 1);
            $full_name = $first_name . ' ' . $middle_initial . '. ' . $last_name;
        }

        return $full_name;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
