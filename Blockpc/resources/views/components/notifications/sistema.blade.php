@props(['notification'])

<div id="alert-additional-content-sistema-{{ $notification->id }}" class="notify-alert-info" role="alert">
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <x-bx-message-dots class="w-6 h-6" />
            <span class="sr-only">Sistema</span>
            <h3 class="text-lg font-medium">Mensaje Sistema</h3>
        </div>
        <div class="">
            <button type="button" class="btn-dissmiss-info" data-dismiss-target="#alert-additional-content-sistema-{{ $notification->id }}" aria-label="Close" wire:click="mark_as_read('{{ $notification->id }}')">
                <span>{{__('common.delete')}}</span>
            </button>
        </div>
    </div>
    <div class="mt-2 mb-4 text-sm">
        {!! nl2br(e($notification->message)) !!}
    </div>
    <div class="flex justify-between items-center">
        <div></div>
        <div class="">
            <div class="text-sm">De: Sistema</div>
            <div class="text-xs text-right">{{ $notification->date }}</div>
        </div>
    </div>
</div>
