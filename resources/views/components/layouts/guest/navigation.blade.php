<nav x-data="{ open: false }" class="nav-dark w-full">
    {{-- Primary Navigation Menu --}}
    <div class="mx-auto px-4 sm:px-6 lg:px-8 h-16">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-4">
                {{-- Logo --}}
                <div class="flex items-center space-x-4 w-64">
                    <a href="{{ route('home') }}">
                        <x-logo class="h-10" src="{{ asset('img/logo.png') }}" />
                    </a>
                    <span class="text-lg font-semibold">{{ config('app.name', 'Guest') }}</span>
                </div>

                {{-- Navigation Links --}}
                <div class="hidden sm:flex sm:space-x-4">
                    <a wire:navigate class="flex items-center dark:hover:bg-gray-800 hover:bg-gray-300 p-2 h-10 rounded-sm" href="{{ route('home') }}">{{ __('Home') }}</a>
                </div>
            </div>

            {{-- Settings Dropdown --}}
            <div class="flex space-x-4">
                <div class="px-2 h-16 flex">
                    <button id="theme-toggle" type="button" class="rounded-lg text-sm p-1 ml-4">
                        <x-bx-sun class="hidden h-6 w-6 text-yellow-600" id="theme-toggle-dark-icon" />
                        <x-bx-moon class="hidden h-6 w-6 text-gray-200" id="theme-toggle-light-icon" />
                    </button>
                </div>

                {{-- Hamburger --}}
                <div class="-mr-2 flex items-center sm:hidden">
                    <button x-on:click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md focus:bg-gray-200 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                        <div :class="open ? 'hidden' : 'inline-flex'">
                            <x-bx-menu class="h-6 w-6" />
                        </div>
                        <div :class="! open ? 'hidden' : 'inline-flex' ">
                            <x-bx-x class="h-6 w-6" />
                        </div>
                    </button>
                </div>

                {{-- User/login options --}}
                <div class="hidden sm:flex sm:items-center">
                </div>
            </div>
        </div>
    </div>

    {{-- Responsive Navigation Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        {{-- Responsive Settings Options --}}
        <div class="pt-4 pb-1 border-t border-b border-gray-500">

        </div>
    </div>
</nav>
