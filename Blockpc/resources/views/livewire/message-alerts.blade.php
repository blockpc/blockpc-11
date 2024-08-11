<div>
    <div class="fixed top-4 inset-x-0 z-20" x-data="{
        open: @entangle('open').live,
        class_alert: @entangle('class_alert').live,
        time: @entangle('time').live
    }"
    x-init="$watch('open', value => setTimeout(() => open = false, time))">
        <div class="w-3/4 mx-auto cursor-pointer" :class="class_alert" x-show="open" x-on:click="open=false" x-transition>
            <div class="flex">
                <div class="flex-1">
                    @if ( $title )
                    <p class="font-bold text-base">{{$title}}</p>
                    @endif
                    <p class="text-sm font-roboto font-medium">{!! $message !!}</p>
                </div>
                <button type="button" class="btn-sm" wire:click="hide()">
                    <x-bx-x class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
</div>
