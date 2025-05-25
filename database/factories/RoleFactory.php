<?php

declare(strict_types=1);

namespace Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

final class RoleFactory extends Factory
{
    protected $model = \App\Models\Role::class;

    public function definition()
    {
        return [
            'name' => fake()->unique()->word(),
            'guard_name' => 'web',
            'display_name' => fake()->sentence(2),
            'description' => fake()->sentence,
        ];
    }
}
