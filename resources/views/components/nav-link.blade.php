@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center p-2 border-b-2 border-indigo-400 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center p-2 border-b-2 border-transparent text-sm font-medium leading-5 hover:border-gray-600 dark:hover:border-gray-300 focus:outline-none focus:border-gray-600 transition duration-150 ease-in-out';
@endphp

<a wire:navigate {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
