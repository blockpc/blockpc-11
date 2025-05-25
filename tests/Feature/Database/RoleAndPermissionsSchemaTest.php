<?php

use Illuminate\Support\Facades\DB;

uses()->group('database');

// RoleAndPermissionsSchemaTest

it('roles table database has expected columns', function () {
    $columns = collect(DB::select('describe roles'))->pluck('Field')->toArray();
    expect($columns)->toBe([
        'id',
        'name',
        'guard_name',
        'description',
        'display_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ]);
});

it('permissions table database has expected columns', function () {
    $columns = collect(DB::select('describe permissions'))->pluck('Field')->toArray();
    expect($columns)->toBe([
        'id',
        'name',
        'guard_name',
        'key',
        'description',
        'display_name',
        'created_at',
        'updated_at',
    ]);
});
