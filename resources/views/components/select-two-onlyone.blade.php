@props([
    'name',
    'title',
    'options',
    'empty_values' => 'Sin registros encontrados',
    'selected_name' => null,
    'selected_id' => null,
    'search_by' => 'Buscar...'
])

@php
    $when_selected = $attributes->get('when_selected');
    $click = $attributes->get('click');
    $search = $attributes->get('search');
@endphp

<div {{ $attributes->only('class')->merge(['class' => '']) }}>
    <div class="w-full relative" x-data="{open:false}" x-on:click.away="open=false">
        <div class="flex space-x-2">
            <button type="button" class="btn-sm btn-select flex justify-between items-center w-full p-2 h-8" x-on:click="open=!open">
                <span class="float-left">{{ title(__($selected_name ?: $title)) }}</span>
                <div class="" :class="open ? 'rotate-180' : ''">
                    <x-bx-chevron-up class="w-4 h-4" />
                </div>
            </button>
            @if ( $selected_id && $click )
            <x-buttons.btn class="btn-danger" wire:click="{{ $click }}">
                <x-bx-x class="w-4 h-4" />
            </x-buttons.btn>
            @endif
        </div>

        <div class="z-10 w-full rounded-b shadow-md py-2 text-dark border-l border-r border-b border-gray-500" x-show="open" x-cloak>
            <div class="m-2">
                <input type="search" class="input input-sm w-full" placeholder="{{ $search_by }}" id="{{ $name }}"
                    wire:model.live.debounce.500ms="{{ $search }}"
                    @keydown.enter="open = false; $event.target.blur()"
                />
            </div>
            <ul class="list-reset px-2 max-h-64 text-sm scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-300 overflow-y-auto">
                {{-- <li class="sticky top-0">
                    <input type="search" class="input input-sm w-full" placeholder="{{ $search_by }}" id="{{ $name }}"
                        wire:model.live.debounce.500ms="{{ $search }}"
                        @keydown.enter="open = false; $event.target.blur()"
                    />
                </li> --}}
                @forelse ($options as $option_id => $option_name)
                <li
                    @if ($when_selected)
                        wire:click="{{ $when_selected }}({{ $option_id }})"
                    @endif
                    x-on:click="open=false"
                    id="option-{{$option_id}}"
                >
                    <div class="p-2 w-full hover:bg-gray-300 hover:dark:bg-gray-600 flex justify-between cursor-pointer text-xs">
                        <span>{{$option_name}}</span>
                        @if ($option_id == $selected_id)
                        <x-bx-check class="w-4 h-4" />
                        @endif
                    </div>
                </li>
                @empty
                <li x-on:click="open=false" wire:click="$set('{{ $search }}', null)">
                    <p class="p-2 block dark:text-red-400 text-red-800 hover:bg-red-200 cursor-pointer">{{ $empty_values }}</p>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
