@props(['icon'])

<a  {{$attributes->merge(['class' => 'flex items-center space-x-2 px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-600']) }}>
    @if ( isset($icon) && $icon )
    @svg($icon, 'ml-3 w-5 h-5')
    @else
    @svg('bx-circle', 'ml-3 w-5 h-5')
    @endif
    <span>{{ $slot }}</span>
</a>
