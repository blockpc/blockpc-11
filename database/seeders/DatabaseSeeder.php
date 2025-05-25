<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        collect(config('seeders')[app()->environment()])
            ->where('callable', true)
            ->each(function ($seeder) {
                $this->call($seeder['name']);
            });

        Schema::enableForeignKeyConstraints();
    }
}
