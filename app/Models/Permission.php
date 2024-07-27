<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as ModelsPermission;

final class Permission extends ModelsPermission
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
        'key',
    ];
}
