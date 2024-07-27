<div>
    <x-page-header titulo="pages.users.titles.table" icon="heroicon-s-users">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
            @can('user create')
            <x-links.href class="btn-sm btn-info space-x-2" href="{{ route('users.create') }}">
                <x-bx-plus class="w-4 h-4" />
                <span>{{ __('pages.users.titles.user') }}</span>
            </x-links.href>
            @endcan
        </x-slot>
    </x-page-header>

    <section class="mt-2 mx-auto w-full">

        <div class="content-table">
            <x-tables.search :search="$search" :paginate="$paginate" :clean="true" name="permissions" />

            <x-tables.table>
                <x-slot name="thead">
                    <tr>
                        <th class="td">{{ __('pages.users.table.name') }}</th>
                        <th class="td">{{ __('pages.users.create.form.email') }}</th>
                        <th class="td text-right">{{ __('common.actions') }}</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @forelse ($this->users as $user)
                        <tr class="tr tr-hover">
                            <td class="td">{{ $user->fullname }}</td>
                            <td class="td">{{ $user->email }}</td>
                            <td class="td">
                                <div class="flex justify-end space-x-2">
                                    @can('user edit')
                                    <x-buttons.btn class="btn-info">
                                        <x-bx-edit class="w-4 h-4" />
                                    </x-buttons.btn>
                                    @endcan
                                    @can('user delete')
                                    <x-buttons.btn class="btn-info">
                                        <x-bx-trash class="w-4 h-4" />
                                    </x-buttons.btn>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                    <x-tables.no-records colspan="3" :search="$search" />
                    @endforelse
                </x-slot>
            </x-tables.table>


            <x-pagination :model="$this->users" />
        </div>


    </section>
</div>
