<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property-read Profile|null $profile
 */
final class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'is_active',
        'password',
        'password_changed_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'password_changed_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

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
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $search
     */
    public function scopeSearch($query, $search = null)
    {
        $query->when($search, function ($query) use ($search) {
            $query->whereLike(['name', 'email', 'profile.firstname', 'profile.lastname'], $search);
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'password_changed_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
