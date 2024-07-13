<?php

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

if (! function_exists('image_profile')) {
    function image_profile(?User $user = null): string
    {
        $user = $user ?? current_user();
        $image = $user->exists ? $user->profile?->image : false;
        if (! $image) {
            $name = str_replace(' ', '+', $user->exists ? $user->name : 'n n');

            return "https://ui-avatars.com/api/?name={$name}";
        }

        return Storage::url($image);
    }
}

if (! function_exists('title')) {
    function title($value): string
    {
        return Str::title($value);
    }
}
