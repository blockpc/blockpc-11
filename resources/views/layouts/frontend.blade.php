<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="font-sans antialiased dark-mode flex flex-col h-full">
        <x-layouts.frontend.navigation />
        <x-layouts.messages />

        <!-- Page Heading -->
        @if ( isset($header) )
        <header class="content flex flex-col space-y-2 p-2">
            {{ $header }}
        </header>
        @endif

        <main class="content">
            {{ $slot }}
        </main>
        <footer class="bg-slate text-center text-sm mt-auto p-4">
            Blockpc | Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
