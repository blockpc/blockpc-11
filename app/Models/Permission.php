<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as ModelsPermission;

/**
 * @property string $display_name
 * @property string $description
 * @property string $key
 */
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

    /**
     * scope search by name and display_name
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $search
     */
    public function scopeSearch($query, $search = null)
    {
        $query->when($search, function ($query) use ($search) {
            $query->whereLike(['display_name', 'description'], $search);
        });
    }
}
