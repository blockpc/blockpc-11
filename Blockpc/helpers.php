<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

if (! function_exists('current_user')) {
    function current_user() : ?Authenticatable
    {
        if (Auth::check()) {
            return Auth::user()->loadMissing('profile', 'permissions');
        }

        return null;
    }
}

if (! function_exists('title')) {
    function title($value): string
    {
        return Str::title($value);
    }
}
