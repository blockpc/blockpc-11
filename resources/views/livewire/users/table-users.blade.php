<div>
    <x-page-header titulo="pages.users.titles.table" icon="heroicon-s-users">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
            @if ( auth()->user()->can('user create') )
            <a  class="btn-sm btn-info space-x-2" href="{{ route('users.create') }}">
                <x-bx-plus class="w-4 h-4" />
                <span>{{ __('pages.users.titles.user') }}</span>
            </a>
            @endif
        </x-slot>
    </x-page-header>
    <section class="mx-auto w-full">
        <table class="table">
            <thead class="thead">
                <tr class="uppercase">
                    <th class="td">{{ __('name') }}</th>
                    <th class="td">{{ __('fullname') }}</th>
                    <th class="td">{{ __('email') }}</th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr class="tr-hover">
                    <td class="td">jhon</td>
                    <td class="td">John Doe</td>
                    <td class="td">jhon@mail.com</td>
                </tr>
                <tr class="tr-hover">
                    <td class="td">jane</td>
                    <td class="td">Jane Doe</td>
                    <td class="td">jane@mail.com</td>
                </tr>
            </tbody>
        </table>
    </section>
</div>
