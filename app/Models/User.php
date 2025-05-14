<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'password_changed_at',
    ];

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
            'password_changed_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getFullnameAttribute(): string
    {
        if ($this->profile) {
            return $this->profile->firstname.' '.$this->profile->lastname;
        }

        return '';
    }

    /**
     * Get the profile associated with the user.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * scope search by 'name', 'email', 'profile.firstname', 'profile.lastname'
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $search
     */
    public function scopeSearch($query, $search = null)
    {
        $query->when($search, function ($query) use ($search) {
            $query->whereLike(['name', 'email', 'profile.firstname', 'profile.lastname'], $search);
        });
    }
}
