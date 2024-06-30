<?php

declare(strict_types=1);

namespace Database\factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ProfileFactory extends Factory
{
    protected $model = \App\Models\Profile::class;

    public function definition()
    {
        return [
            'firstname' => $this->faker->firstname(),
            'lastname' => $this->faker->lastname(),
        ];
    }

}
