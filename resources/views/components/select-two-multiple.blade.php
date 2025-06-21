@props([
    'name',
    'title',
    'options',
    'empty_values' => 'Sin registros encontrados',
    'selected_ids' => [],
    'search_by' => 'Buscar...'
])

@php
    $options = collect($options);
    $selected_ids = collect($selected_ids);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'flex flex-col text-xs font-semibold']) }}>
    <div class="w-full relative" x-data="{open:false}" x-on:click.away="open=false">
        <div class="flex space-x-2">
            <button type="button" class="btn-sm btn-select flex justify-between items-center w-full p-2 h-8" x-on:click="open=!open">
                <span class="float-left">{{ title(__($title)) }}</span>
                <div class="" :class="open ? 'rotate-180' : ''">
                    <x-bx-chevron-up class="w-4 h-4" />
                </div>
            </button>
        </div>
        <div class="div-select2" x-show="open" x-cloak>
            <ul class="list-reset px-2 max-h-40 text-sm scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-300 overflow-y-auto">
                <li class="sticky top-0 bg-dark">
                    <input wire:model.live.debounce.500ms="{{ $attributes->get('search') }}" id="{{ $name }}" @keydown.enter="open = false; $event.target.blur()" type="text" class="input input-sm w-full" placeholder="{{ $search_by }}">
                </li>
                @forelse ($options as $option_id => $option_name)
                <li
                    @class([
                        'bg-gray-300 dark:bg-gray-800/50' => $selected_ids->contains($option_id)
                    ])
                    @if ($attributes->has('when_selected'))
                        wire:click="{{ $attributes->get('when_selected') }}({{ $option_id }})"
                    @endif
                    x-on:click="open=false"
                    id="etiqueta-{{ $option_id }}"
                >
                    <div class="p-2 w-full hover:bg-gray-300 hover:dark:bg-gray-600 flex justify-between cursor-pointer text-xs">
                        <span>{{ $option_name }}</span>
                        @if ( $selected_ids->contains($option_id) )
                        <x-bx-check class="w-4 h-4" />
                        @endif
                    </div>
                </li>
                @empty
                <li class="" x-on:click="open=false" wire:click="$set('{{ $attributes->get('search') }}', null)">
                    <p class="p-2 block dark:text-red-400 text-red-800 hover:bg-red-200 cursor-pointer">{{ $empty_values }}</p>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
