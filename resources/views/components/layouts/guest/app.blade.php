<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-slate-100 text-black dark:bg-slate-800 dark:text-white flex flex-col h-full">
        <x-layouts.guest.navigation />

        <!-- Page Heading -->
        <header class="content flex flex-col space-y-2 p-2">
            <x-layouts.messages />
            {{-- @include('layouts.frontend.messages') --}}
            {{ $header }}
        </header>

        <main class="content">
            {{ $slot }}
        </main>
        <footer class="text-center text-sm bg-slate-100 text-black dark:bg-slate-800 dark:text-white mt-auto p-4">
            Blockpc | Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
