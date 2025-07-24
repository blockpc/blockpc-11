@props(['notification'])

<div id="alert-additional-content-success-{{ $notification->id }}" class="notify-alert-success" role="alert">
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <x-bx-message-dots class="w-6 h-6" />
            <span class="sr-only">De Confirmación</span>
            <h3 class="text-lg font-medium">Mensaje de Confirmación</h3>
        </div>
        <div class="">
            <button type="button" class="btn-dissmiss-success" data-dismiss-target="#alert-additional-content-success-{{ $notification->id }}" aria-label="Close" wire:click="mark_as_read('{{ $notification->id }}')">
                <span>{{__('common.delete')}}</span>
            </button>
        </div>
    </div>
    <div class="mt-2 mb-4 text-sm">
        {!! nl2br(e($notification->message)) !!}
    </div>
    <div class="flex justify-between items-center">
        <div>
            <button type="button" class="btn-dissmiss-success" wire:click="open_response('{{ $notification->id }}')">
                <span>{{__('common.answer')}}</span>
            </button>
        </div>
        <div class="">
            <div class="text-sm">De: {{ $notification->from }}</div>
            <div class="text-xs text-right">{{ $notification->date }}</div>
        </div>
    </div>
</div>
