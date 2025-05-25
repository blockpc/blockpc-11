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
    <body class="font-sans antialiased dark-mode flex flex-col h-full">
        <div class="h-full flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <x-layouts.messages />
            <div>
                <a href="{{ route('home') }}" wire:navigate>
                    <x-logo class="w-40 h-20" src="{{ asset('img/logo150x75.png') }}" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-lg overflow-hidden sm:rounded-lg border border-gray-300 dark:border-gray-500">
                {{ $slot }}
            </div>
        </div>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
