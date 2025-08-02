<div>
    <x-page-header titulo="pages.users.titles.table" icon="heroicon-s-users">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
            @can('user create')
            <x-buttons.btn class="btn-info" wire:click="create_user">
                <x-bx-plus class="w-4 h-4" />
                <span>{{ __('pages.users.titles.user') }}</span>
            </x-buttons.btn>
            @endcan
        </x-slot>
    </x-page-header>

    <section class="mt-2 mx-auto w-full">

        <div class="content-table">
            <x-tables.search :search="$search" :paginate="$paginate" :clean="true" name="permissions">
                <x-slot name="actions">
                    @if( !$soft_deletes && current_user()->can('user delete') )
                    <x-buttons.btn class="btn-danger" wire:click="show_deleteds" title="Mostrar eliminados">
                        <x-bx-trash class="w-4 h-4" />
                    </x-buttons.btn>
                    @endif
                    @if( $soft_deletes && current_user()->can('user restore') )
                    <x-buttons.btn class="btn-secondary" wire:click="show_deleteds" title="Ocultar eliminados">
                        <x-bx-check class="w-4 h-4" />
                    </x-buttons.btn>
                    @endif
                </x-slot>
            </x-tables.search>

            <x-tables.table>
                <x-slot name="thead">
                    <tr>
                        <th class="td">{{ __('pages.users.table.name') }}</th>
                        <th class="td">{{ __('pages.users.table.email') }}</th>
                        <th class="td text-right">{{ __('common.actions') }}</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @forelse ($this->users as $user)
                        <tr class="tr tr-hover text-xs">
                            <td class="td">{{ $user->fullname }}</td>
                            <td class="td">{{ $user->email }}</td>
                            <td class="td">
                                <div class="flex justify-end space-x-2">
                                    @if ($soft_deletes)
                                        @can('user restore')
                                            <x-buttons.btn class="btn-secondary" wire:click="restore_user({{ $user->id }})" title="{{ __('pages.users.titles.restore') }}">
                                                <x-bx-check class="w-4 h-4" />
                                            </x-buttons.btn>
                                        @endcan
                                    @else
                                        @can('user update')
                                            <x-links.href class="btn-sm btn-success" href="{{ route('users.update', ['user' => $user->id]) }}" title="{{ __('pages.users.titles.edit') }}">
                                                <x-bx-edit class="w-4 h-4" />
                                            </x-links.href>
                                        @endcan
                                        @can('user delete')
                                            <x-buttons.btn class="btn-danger" wire:click="delete_user({{ $user->id }})" title="{{ __('pages.users.titles.delete') }}">
                                                <x-bx-trash class="w-4 h-4" />
                                            </x-buttons.btn>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                    <x-tables.no-records span="3" :search="$search" />
                    @endforelse
                </x-slot>
            </x-tables.table>

            <x-pagination :model="$this->users" />
        </div>
    </section>
</div>
