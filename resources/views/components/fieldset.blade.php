@props(['title', 'color' => 'gray'])

<div>
    <fieldset class="border border-solid dark:border-gray-500 border-gray-300 rounded-lg p-3">
        <legend class="text-sm font-semibold px-2 dark:text-gray-400 text-gray-400">{{ __($title) }}</legend>

        {{ $slot }}
    </fieldset>
</div>
