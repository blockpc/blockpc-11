<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as ModelsRole;

final class Role extends ModelsRole
{
    use SoftDeletes;
    use HasFactory;

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
}
