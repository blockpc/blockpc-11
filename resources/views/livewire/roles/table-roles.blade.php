<div>
    <x-page-header titulo="pages.roles.titles.table" icon="heroicon-s-users">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
            @can('role create')
            <x-links.href class="btn-sm btn-info" href="{{ route('roles.create') }}">
                <span>{{__('pages.roles.titles.create')}}</span>
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
                        <th class="td">{{ __('pages.roles.table.name') }}</th>
                        <th class="td">{{ __('pages.roles.table.description') }}</th>
                        <th class="td text-right">{{ __('common.actions') }}</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @forelse ($this->roles as $role)
                        <tr class="tr tr-hover">
                            <td class="td">{{ $role->display_name }}</td>
                            <td class="td">{{ $role->description }}</td>
                            <td class="td">
                                <div class="flex justify-end space-x-2">
                                    @can('role edit')
                                    <x-buttons.btn class="btn-success">
                                        <x-bx-edit class="w-4 h-4" />
                                    </x-buttons.btn>
                                    @endcan
                                    @can('role delete')
                                    <x-buttons.btn class="btn-danger">
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

            <x-pagination :model="$this->roles" />
        </div>

    </section>
</div>
