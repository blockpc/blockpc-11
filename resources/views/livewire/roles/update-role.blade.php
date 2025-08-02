<div>
    <x-page-header titulo="pages.roles.titles.edit" icon="bx-shield">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
            <x-links.href class="btn-sm btn-default" href="{{ route('roles.table') }}">
                <span>{{__('pages.roles.titles.table')}}</span>
            </x-links.href>
        </x-slot>
    </x-page-header>

    <section class="mt-2 mx-auto w-full">
        <form wire:submit="updateRole">
            <div class="grid gap-8">

                {{-- Sobre el cargo --}}
                <x-fieldset>
                    <div class="grid md:grid-cols-3 gap-4">

                        <div class="flex flex-col">
                            <legend class="upper-legend">{{__('Sobre el cargo')}}</legend>
                            <p class="legend italic">{{__('Informacióm asociada al cargo')}}</p>
                        </div>

                        <div class="md:col-span-2 grid gap-4">
                            <x-inputs.text name="create_display_name_name" label="{{ __('pages.roles.attributes.form.display_name') }}" wire:model="display_name" title="Nombre del cargo" autocomplete="username" required />

                            <x-inputs.textarea class="text-xs" name="create_description_name" label="{{ __('pages.roles.attributes.form.description') }}" wire:model="description" title="Descripción del cargo" />

                            <div class="flex justify-end space-x-2">
                                <x-links.href class="btn-sm btn-cancel" href="{{ route('roles.table') }}">
                                    <span>{{ __('common.cancel') }}</span>
                                </x-links.href>
                                <x-buttons.submit class="btn-success">
                                    {{ __('pages.roles.titles.edit') }}
                                </x-buttons.submit>
                            </div>
                        </div>
                    </div>
                </x-fieldset>

                {{-- Permisos asociados al cargo --}}
                <x-fieldset>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="flex flex-col">
                            <legend class="upper-legend">{{__('Permisos asociados al cargo')}}</legend>
                            <p class="legend italic">{{__('Seleccione los permisos que quiere adjuntar al cargo')}}</p>
                            <p class="legend italic">{{__('Numero de permisos del cargo')}}: {{ count($permisos_ids) }} </p>
                        </div>

                        <div class="md:col-span-2 grid gap-2">
                            <x-toggle-sm class="whitespace-nowrap" name="active_permission_role" yes="Permisos Activos" not="Mostrando Todos" wire:model.live="permissions_role" />
                            <x-tables.search :search="$search" :paginate="$paginate" :clean="true">
                                <x-slot name="actions">
                                    <select name="select_group" id="select_group" class="text-sm select-sm scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-700" wire:model.live="group_id">
                                        <option value="">Todos</option>
                                        @foreach ($this->groups as $value)
                                            <option value="{{$value}}">{{ __('permissions.'.$value.'.title') }}</option>
                                        @endforeach
                                    </select>
                                </x-slot>
                            </x-tables.search>

                            <x-tables.table>
                                <x-slot name="thead">
                                    <tr>
                                        <th scope="col" class="td">{{ __('Permission') }}</th>
                                        <th scope="col" class="td">{{ __('Group') }}</th>
                                        <th scope="col" class="td">
                                            <span class="sr-only">{{ __('roles.table.actions') }}</span>
                                        </th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @forelse ($this->permisos as $permiso)
                                    <tr @class([
                                        'tr text-xs',
                                        'tr-hover' => !in_array($permiso->id, $permisos_ids),
                                        'tr-info' => in_array($permiso->id, $permisos_ids),
                                    ])>
                                        <td class="td">
                                            <div class="flex flex-col space-y-1">
                                                <p class="text-sm font-semibold">{{ $permiso->display_name }}</p>
                                                <p class="italic">{{ $permiso->description }}</p>
                                            </div>
                                        </td>
                                        <td class="td">{{ __('permissions.'.$permiso->key.'.title') }}</td>
                                        <td class="td">
                                            <div class="td-actions">
                                                @if ( in_array($permiso->id, $permisos_ids) )
                                                <x-buttons.btn class="btn-danger" wire:click="quitar_permiso({{ $permiso->id }})">
                                                    <x-bx-x class="w-4 h-4" />
                                                </x-buttons.btn>
                                                @else
                                                <x-buttons.btn class="btn-info" wire:click="asignar_permiso({{ $permiso->id }})">
                                                    <x-bx-plus class="w-4 h-4" />
                                                </x-buttons.btn>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <x-tables.no-records id="permission_role" span="3" :search="$search" />
                                    @endforelse
                                </x-slot>
                            </x-tables.table>

                            <x-tables.pagination :model="$this->permisos" />
                        </div>
                    </div>
                </x-fieldset>

                <div class="flex justify-end space-x-2">
                    <x-links.href class="btn-sm btn-cancel" href="{{ route('roles.table') }}">
                        <span>{{ __('common.cancel') }}</span>
                    </x-links.href>
                    <x-buttons.submit class="btn-success">
                        {{ __('pages.roles.titles.edit') }}
                    </x-buttons.submit>
                </div>
            </div>
        </form>
    </section>
</div>
