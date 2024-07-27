<div class="nav-dark w-64 fixed h-sidebar left-0 top-16 z-50 py-2 shadow font-roboto font-semibold transform transition-all duration-500 ease-in-out overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-800" :class="sidebar ? 'translate-x-0' : '-translate-x-full'" x-on:click.away="sidebar=false" x-show="sidebar" x-cloak
    x-transition:enter="translate-x-0 ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="translate-x-0 ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    >

    <x-links.sidebar-menu :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        <div class="flex space-x-2 items-center">
            <x-bx-layout class="w-5 h-5" />
            <span>{{__('pages.dashboard.titles.link')}}</span>
        </div>
    </x-links.sidebar-menu>

    <hr class="hr-xs">

    <x-blockpc.menu-package />

    <hr class="hr-xs">

    <x-links.sidebar-menu :href="route('users.table')" :active="request()->routeIs('users.*')" permission="user list">
        <div class="flex space-x-2 items-center">
            <x-heroicon-s-users class="w-5 h-5" />
            <span>{{__('pages.users.titles.link')}}</span>
        </div>
    </x-links.sidebar-menu>

    <x-links.sidebar-menu :href="route('roles.table')" :active="request()->routeIs('roles.*')" permission="role list">
        <div class="flex space-x-2 items-center">
            <x-bx-layout class="w-5 h-5" />
            <span>{{__('pages.roles.titles.link')}}</span>
        </div>
    </x-links.sidebar-menu>

    <x-links.sidebar-menu :href="route('permissions.table')" :active="request()->routeIs('permissions.*')" permission="permission list">
        <div class="flex space-x-2 items-center">
            <x-bx-layout class="w-5 h-5" />
            <span>{{__('pages.permissions.titles.link')}}</span>
        </div>
    </x-links.sidebar-menu>
</div>
