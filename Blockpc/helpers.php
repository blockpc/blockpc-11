<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (! function_exists('current_user')) {
    /**
     * Helper para obtener el usuario autenticado con relaciones precargadas.
     */
    function current_user(): ?User
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
        $image = $user?->exists ? $user->profile?->image : false;
        if (! $image) {
            $name = str_replace(' ', '+', $user?->exists ? $user->fullname : 'n n');

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

if (! function_exists('formato')) {
    function formato($date, $format_out = 'd/m/Y H:i'): string
    {
        return Str::title($date?->translatedFormat($format_out) ?? '--');
    }
}

if (! function_exists('tiempo')) {
    function tiempo($seconds): string|false
    {
        return gmdate('H:i:s', $seconds);
    }
}
