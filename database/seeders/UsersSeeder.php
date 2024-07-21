<?php

declare(strict_types=1);

namespace Database\seeders;

use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sudo = User::create([
            'name' => 'sudo',
            'email' => 'sudo@mail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
        $sudo->profile()->create([
            'firstname' => 'Juan',
            'lastname' => 'Perez',
        ]);
        $sudo->assignRole('sudo');

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
        $admin->profile()->create([
            'firstname' => 'Jhon',
            'lastname' => 'Doe',
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
        $user->profile()->create([
            'firstname' => 'Jane',
            'lastname' => 'Donovan',
        ]);
        $user->assignRole('user');

        User::factory(20)->create()->each(function ($user) {
            $phone = Profile::factory()->make();
            $user->profile()->save($phone); // phone() is hasOne ralationship in User.php
        });
    }
}
