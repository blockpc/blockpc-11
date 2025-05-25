@props(['titulo', 'icon' => 'bx-link'])

<div class="page-header">
    <div class="flex space-x-2 items-center">
        @unless(app()->runningUnitTests())
        @svg($icon, 'w-6 h-6')
        @endunless
        <span class="font-semibold">{{__($titulo)}}</span>
    </div>
    @isset($buttons)
    <div class="flex space-x-2 items-center">
        {{ $buttons }}
    </div>
    @endisset
</div>
