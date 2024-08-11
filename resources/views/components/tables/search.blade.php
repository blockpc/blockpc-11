@props(['search', 'paginate', 'clean' => false, 'name' => 'search', 'placeholder' => 'Search'])

<div class="flex flex-col md:flex-row justify-between items-center my-2">

    <div class="w-full md:w-auto flex space-x-2">
        <div class="w-full relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-bx-search class="w-4 h-4 fill-current" />
            </div>
            <input wire:model.live.debounce.250ms="search" type="text" name="search_{{ $name }}" id="search_{{ $name }}" class="input-search" placeholder="{{ $placeholder }}" autocomplete="off">
            @if ( $clean && $search )
            <button type="button" wire:click="clean_search" class="btn-clean-search">
                <x-bx-x class="w-4 h-4" />
            </button>
            @endif
        </div>
        <select wire:model.live="paginate" id="paginate_{{ $name }}" name="paginate_{{ $name }}" class="pagination h-8">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
    </div>

    <div class="w-full md:w-auto flex justify-end items-center space-x-2">
        {{ $actions ?? '' }}
    </div>
</div>
