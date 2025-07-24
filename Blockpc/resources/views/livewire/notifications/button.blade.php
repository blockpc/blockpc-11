<div>
    <div class="h-16 flex" x-data="{open: @entangle('open')}">
        <button class="btn-sm btn-navbar" title="Click para ver o cerrar" :class="open ? 'transform rotate-45' : 'transform rotate-0'" wire:click="open_close">
            <span class="sr-only">{{__('common.notifications')}}</span>
            @if ( $unreadNotifications->count() )
            <span class="absolute top-2 right-0 h-2 w-2 mt-1 mr-2 bg-red-500 rounded-full"></span>
            <span class="absolute top-2 right-0 h-2 w-2 mt-1 mr-2 bg-red-500 rounded-full animate-ping"></span>
            @endif
            <x-bx-bell class="h-6 w-6" />
        </button>
    </div>
</div>
