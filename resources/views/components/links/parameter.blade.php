@props([
    'route' => '#',
    'active' => false,
    'submenus' => [],
    'first' => false,
    'last' => false,
    'permission' => true
])

@if ( $permission )
    <div class="{{ $submenus ? 'group inline-block relative w-full' : '' }}">
        <a wire:navigate href="{{ $route }}" @class([
            'link-parameter',
            'link-parameter-active' => $active,
            'link-parameter-no-active border-r border-l' => !$active,
            'border border-t-nonde rounded-b-lg' => $last,
            'border border-b-nonde rounded-t-lg' => $first
        ])>

            <div class="flex items-center justify-between w-full">
                <div class="flex items-center">
                    {{ $slot }}
                </div>
                @if ( $submenus )
                    <div class="group-hover:rotate-180">
                        @svg('bx-caret-down', 'w-4 h-4')
                    </div>
                @endif
            </div>

        </a>
        @if ( $submenus )
        <ul class="parameter-submenu">
            @foreach ($submenus as $key => $submenu)
                <li class="">
                    <a @class([
                        'parameter-submenu-li',
                        'rounded-b-lg' => $loop->last
                    ]) href="{{ $submenu }}">{{$key}}</a>
                </li>
            @endforeach
        </ul>
        @endif
    </div>
@endif
