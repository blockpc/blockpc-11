<?php

use Illuminate\Support\Facades\DB;

uses()->group('database');

// UsersSchemaTest

it('users table database has expected columns', function () {
    $columns = collect(DB::select('describe users'))->pluck('Field')->toArray();
    expect($columns)->toBe([
        'id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'password_changed_at',
        'remember_token',
        'deleted_at',
        'created_at',
        'updated_at',
    ]);
});

it('profiles table database has expected columns', function () {
    $columns = collect(DB::select('describe profiles'))->pluck('Field')->toArray();
    expect($columns)->toBe([
        'id',
        'firstname',
        'lastname',
        'image',
        'user_id',
    ]);
});

it('images table database has expected columns', function () {
    $columns = collect(DB::select('describe images'))->pluck('Field')->toArray();
    expect($columns)->toBe([
        'id',
        'name',
        'url',
        'imageable_type',
        'imageable_id',
        'created_at',
        'updated_at',
    ]);
});
