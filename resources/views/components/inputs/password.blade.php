@props(['name', 'label' => null, 'required' => false])

@php
    $inputName = $name ?? 'password';
    $wireModel = $attributes->wire('model')->value() ?? null;
@endphp

<div {{ $attributes->only('class') }} x-data="{ show_password: false }">
    @if ($label)
        <label class="label" for="{{ $inputName }}">
            <span>{{ title(__($label)) }}</span>
            @if ($required)
                <span class="ml-1 text-red-600 dark:text-red-400">*</span>
            @endif
        </label>
    @endif

    <div class="flex items-center space-x-2">
        <input
            {{ $attributes->except('class') }}
            name="{{ $inputName }}"
            id="{{ $inputName }}"
            class="input input-sm border-dark p-2 @error($wireModel) border-error @enderror"
            :type="show_password ? 'text' : 'password'"
            autocomplete="new-password"
        />

        <button
            type="button"
            class="btn-sm btn-default"
            x-on:click="show_password = !show_password"
            :aria-label="show_password ? 'Mostrar' : 'Ocultar'"
            :title="show_password ? 'Mostrar' : 'Ocultar'"
        >
            {{-- <x-heroicon-o-eye class="w-4 h-4" x-show="show_password" x-cloak />
            <x-heroicon-o-eye-slash class="w-4 h-4" x-show="!show_password" x-cloak /> --}}
            @unless(app()->runningUnitTests())
                <x-heroicon-o-eye class="w-4 h-4" x-show="show_password" x-cloak />
                <x-heroicon-o-eye-slash class="w-4 h-4" x-show="!show_password" x-cloak />
            @endunless
        </button>
    </div>

    @error($wireModel)
        <div class="text-error">{{ $message }}</div>
    @enderror
</div>
