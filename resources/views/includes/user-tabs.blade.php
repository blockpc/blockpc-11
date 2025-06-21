<div class="" x-data="{show:false}">
    <div class="menu-package-left-title">
        <span class="text-sm">{{ __('smo::auditorias.title') }}</span>
        <button type="button" class="btn-sm btn-action md:hidden" x-on:click="show=!show">
            <x-bx-menu class="w-4 h-4" x-show="!show" />
            <x-bx-x class="w-4 h-4" x-show="show" />
        </button>
    </div>
    <div class="flex flex-col space-y-2 p-2 md:block" :class="show ? '' : 'hidden'">
        <div class="w-full bg-parameter">

            {{-- <x-menus.parameter :route="route('auditoria.auditing')" :active="route_active('auditoria.auditing', true)" :first="1">
                <span>{{__('Auditoria de Trazabilidad')}}</span>
            </x-menus.parameter> --}}

            <x-links.parameter :active="false" :first="1">
                <span>{{__('Auditoria de Trazabilidad')}}</span>
            </x-links.parameter>

            <x-links.parameter :active="false">
                <span>{{__('smo::auditorias.histories.menu')}}</span>
            </x-links.parameter>

            <x-links.parameter :active="false">
                <span>{{__('smo::auditorias.signs.menu')}}</span>
            </x-links.parameter>

            <x-links.parameter :active="false">
                <span>{{__('smo::auditorias.documents.menu')}}</span>
            </x-links.parameter>

            <x-links.parameter :active="false">
                <span>{{__('smo::auditorias.externals.menu')}}</span>
            </x-links.parameter>

            <x-links.parameter :active="false">
                <span>{{__('smo::auditorias.procedures.menu')}}</span>
            </x-links.parameter>

            <x-links.parameter :active="false">
                <span>{{__('smo::auditorias.turns.menu')}}</span>
            </x-links.parameter>

            <x-links.parameter :active="false" :last="1">
                <span>{{__('smo::auditorias.trainings.menu')}}</span>
            </x-links.parameter>
        </div>
    </div>
</div>