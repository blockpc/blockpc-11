@props(['titulo', 'icon' => 'bx-link'])

<div class="page-header">
    <div class="flex space-x-2 items-center">
        @svg($icon, 'w-6 h-6')
        <span>{{__($titulo)}}</span>
    </div>
    <div class="flex space-x-2 items-center">
        {{ $buttons ?? '' }}
    </div>
</div>
