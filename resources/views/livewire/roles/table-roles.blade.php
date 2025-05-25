<div>
    <x-page-header titulo="pages.roles.titles.table" icon="bx-shield">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
            @can('role create')
            <x-buttons.btn class="btn-primary" wire:click="create_role">
                <x-bx-plus class="w-4 h-4" />
                <span>{{__('pages.roles.titles.create')}}</span>
            </x-buttons.btn>
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
                        <th class="td">{{ __('pages.roles.table.permissions') }}</th>
                        <th class="td text-right">{{ __('common.actions') }}</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @forelse ($this->roles as $role)
                        <tr class="tr tr-hover">
                            <td class="td">
                                <div class="flex flex-col space-y-1">
                                    <span class="font-semibold">{{ $role->display_name }}</span>
                                    <span class="text-xs italic">{{ $role->description }}</span>
                                </div>
                            </td>
                            <td class="td">{{ $role->permissions_count }}</td>
                            <td class="td">
                                <div class="flex justify-end space-x-2">
                                    @can('role edit')
                                    <x-links.href class="btn-sm btn-success" href="{{ route('roles.update', ['role' => $role->id]) }}">
                                        <x-bx-pencil class="w-4 h-4" />
                                    </x-links.href>
                                    @endcan
                                    @if ( $role->canDelete && current_user()->can('role delete') )
                                    <x-buttons.btn class="btn-danger" wire:click="role_delete({{ $role->id }})">
                                        <x-bx-trash class="w-4 h-4" />
                                    </x-buttons.btn>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-tables.no-records span="3" :search="$search" />
                    @endforelse
                </x-slot>
            </x-tables.table>

            <x-pagination :model="$this->roles" />
        </div>

    </section>

    <div>
        <livewire:roles.create-role />
        <livewire:roles.delete-role />
    </div>
</div>
