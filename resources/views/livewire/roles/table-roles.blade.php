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

        <table class="table">
            <thead class="thead">
                <tr>
                    <th class="td">{{ __('pages.roles.table.name') }}</th>
                    <th class="td">{{ __('pages.roles.table.description') }}</th>
                    <th class="td"></th>
                </tr>
            </thead>
            <tbody class="tbody">
                @forelse ($this->roles as $role)
                    <tr class="tr-hover">
                        <td class="td">{{ $role->display_name }}</td>
                        <td class="td">{{ $role->description }}</td>
                        <td class="td">
                            <div class="flex justify-end space-x-2">
                                @can('role edit')
                                <x-buttons.btn class="btn-info">
                                    <x-bx-edit class="w-4 h-4" />
                                </x-buttons.btn>
                                @endcan
                                @can('role delete')
                                <x-buttons.btn class="btn-info">
                                    <x-bx-trash class="w-4 h-4" />
                                </x-buttons.btn>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="tr-hover">
                        <td class="td" colspan="3">{{ __('pages.roles.titles.empty') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <x-pagination :model="$this->roles" />

    </section>
</div>
