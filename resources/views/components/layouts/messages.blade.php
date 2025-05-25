@session('info')
<div class="alert alert-info m-2" id="alert-message-info" x-transition>
    <div class="flex">
        <div class="flex-1">
            <p class="font-bold">{{__('Información!!')}}!</p>
            <p class="text-sm">{!! $value !!}.</p>
        </div>
        <button type="button" class="btn-sm" onclick="closeAlert('alert-message-info')">
            <x-bx-x class="w-4 h-4" />
        </button>
    </div>
</div>
@endsession
@session('error')
<div class="alert alert-danger m-2" id="alert-message-error" x-transition>
    <div class="flex">
        <div class="flex-1">
            <p class="font-bold">{{__('Error!!')}}!</p>
            <p class="text-sm">{!! $value !!}.</p>
        </div>
        <button type="button" class="btn-sm" onclick="closeAlert('alert-message-error')">
            <x-bx-x class="w-4 h-4" />
        </button>
    </div>
</div>
@endsession
@session('success')
<div class="alert alert-success m-2" id="alert-message-success" x-transition>
    <div class="flex">
        <div class="flex-1">
            <p class="font-bold">{{__('Exito!!')}}!</p>
            <p class="text-sm">{!! $value !!}.</p>
        </div>
        <button type="button" class="btn-sm" onclick="closeAlert('alert-message-success')">
            <x-bx-x class="w-4 h-4" />
        </button>
    </div>
</div>
@endsession
@session('warning')
<div class="alert alert-warning m-2" id="alert-message-warning" x-transition>
    <div class="flex">
        <div class="flex-1">
            <p class="font-bold">{{__('Atención!!')}}!</p>
            <p class="text-sm">{!! $value !!}.</p>
        </div>
        <button type="button" class="btn-sm" onclick="closeAlert('alert-message-warning')">
            <x-bx-x class="w-4 h-4" />
        </button>
    </div>
</div>
@endsession
