<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Profile extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'firstname',
        'lastname',
        'image',
        'user_id',
    ];

    # boots methods for complete the name of user when create or update a profile
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profile) {
            $profile->user->name = $profile->firstname . ' ' . $profile->lastname;
            $profile->user->save();
        });

        static::saving(function ($profile) {
            $profile->user->name = $profile->firstname . ' ' . $profile->lastname;
            $profile->user->save();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
