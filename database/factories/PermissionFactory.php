<?php

declare(strict_types=1);

namespace Database\factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition()
    {
        return [
            'name' => fake()->unique()->word(),
            'guard_name' => 'web',
            'display_name' => fake()->sentence(2),
            'description' => fake()->sentence,
            'key' => fake()->unique()->word(),
        ];
    }
}
