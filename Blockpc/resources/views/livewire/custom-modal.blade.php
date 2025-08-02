<div class="" x-data="{ showModal : @entangle('show') }">
    <div x-show="showModal" class="modal-base-20"
        x-transition:enter="transition ease duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak>
        <!-- Modal -->
        <div class="modal-content scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-700 min-h-[50vh] min-w-[50vw]"
            x-transition:enter="transition ease duration-100 transform"
            x-transition:enter-start="opacity-0 scale-90 translate-y-1"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease duration-100 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-1">

            <div class="flex flex-col max-h-screen">
                <div class="modal-header border-b-dark">
                    <div class="font-bold block text-lg">
                        {{ $title ? __($title) : 'Modal' }}
                    </div>
                    <div class="">
                        <x-buttons.close wire:click="closeModal" />
                    </div>
                </div>
                <div class="flex-1">
                    @if($view)
                        @livewire($view, $params, key($title ?? 'modal'))
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
