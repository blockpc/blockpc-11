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

    <section class="mt-2 mx-auto w-full">

        <table class="table">
            <thead class="thead">
                <tr>
                    <th class="td">{{ __('name') }}</th>
                    <th class="td">{{ __('email') }}</th>
                    <th class="td"></th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr class="tr-hover">
                    <td class="td">jhon</td>
                    <td class="td">jhon@mail.com</td>
                    <td class="td"></td>
                </tr>
                <tr class="tr-hover">
                    <td class="td">jane</td>
                    <td class="td">jane@mail.com</td>
                    <td class="td"></td>
                </tr>
                @forelse ($this->users as $user)
                    <tr class="tr-hover">
                        <td class="td">{{ $user->name }}</td>
                        <td class="td">{{ $user->email }}</td>
                        <td class="td"></td>
                    </tr>
                @empty
                    <tr class="tr-hover">
                        <td class="td" colspan="3">{{ __('pages.users.messages.empty') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <x-pagination :model="$this->users" />

    </section>
</div>
