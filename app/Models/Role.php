<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as ModelsRole;

/**
 * @property string $display_name
 */
final class Role extends ModelsRole
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
    ];

    const SUDO = 'sudo';

    const ADMIN = 'admin';

    const USER = 'user';

    const ROLES_NOT_DELETES = [
        self::SUDO,
        self::ADMIN,
        self::USER,
    ];

    public function getCanDeleteAttribute(): bool
    {
        return ! in_array($this->name, self::ROLES_NOT_DELETES);
    }

    /**
     * scope search by name and display_name
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $search
     */
    public function scopeSearch($query, $search = null)
    {
        $query->when($search, function ($query) use ($search) {
            $query->whereLike(['display_name', 'description'], $search);
        });
    }
}
