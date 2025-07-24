<div>
    <x-page-header titulo="pages.users.titles.edit" icon="heroicon-s-users">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
            <x-links.href class="btn-sm btn-default space-x-2" href="{{ route('users.table') }}">
                <x-heroicon-s-users class="w-4 h-4" />
                <span>{{__('pages.users.titles.table')}}</span>
            </x-links.href>
        </x-slot>
    </x-page-header>

    <section class="mt-2 mx-auto w-full">
        <div class="grid gap-8">

            <x-fieldset>
                <div class="grid lg:grid-cols-3 gap-4">
                    <div class="flex flex-col">
                        <legend class="upper-legend">{{__('Sobre el Usuario')}}</legend>
                        <p class="legend italic">{{__('Información asociada al usuario')}}</p>
                    </div>

                    <div class="lg:col-span-2">
                        <form wire:submit="save">
                            <div class="grid grid-cols-2 gap-4">
                                <x-inputs.text name="update_user_firstname" label="{{ __('pages.users.attributes.form.firstname') }}" wire:model="firstname" required />

                                <x-inputs.text name="update_user_lastname" label="{{ __('pages.users.attributes.form.lastname') }}" wire:model="lastname" required />

                                <div class="col-span-2">
                                    <x-inputs.text name="update_user_email" label="{{ __('pages.users.attributes.form.email') }}" wire:model="email" autocomplete="username" required />
                                </div>

                                <x-inputs.text name="update_user_name" label="{{ __('pages.users.attributes.form.name') }}" wire:model="name" autocomplete="username" required />

                                <div class="col-span-2 flex justify-end space-x-2">
                                    <x-links.href class="btn-sm btn-cancel" href="{{ route('roles.table') }}">
                                        <span>{{ __('common.cancel') }}</span>
                                    </x-links.href>
                                    <x-buttons.submit class="btn-success">
                                        {{ __('pages.users.titles.edit') }}
                                    </x-buttons.submit>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </x-fieldset>

            <x-fieldset>
                <div class="grid lg:grid-cols-3 gap-4">

                    <div class="flex flex-col">
                        <legend class="upper-legend">{{__('Sobre sus Cargos')}}</legend>
                        <p class="legend italic">{{__('Cargos asociados al usuario')}}</p>
                    </div>

                    <div class="lg:col-span-2 grid gap-2" x-data="{show_roles: false}">

                        <div class="flex space-x-2">
                            <div class="w-full">
                                <x-select-two-only-select
                                    name="select_two_add_role_to_user"
                                    title="Agregar Cargo..."
                                    :options="$this->allRoles"
                                    search="selected_two_role_search"
                                    when_selected="select_role"
                                    selected_name="{{ $selected_two_role_name }}"
                                    selected_id="{{ $selected_two_role_id }}"
                                    search_by="Buscar por nombre"
                                />
                            </div>
                            <x-buttons.btn class="btn-default h-8" x-on:click="show_roles=!show_roles">
                                <span class="flex items-center">Mostrar ({{ $this->userRoles()->count() }})</span>
                            </x-buttons.btn>
                        </div>

                        <div class="flex space-x-2" x-show="show_roles" x-cloak>
                            @forelse ($this->userRoles as $cargo_id => $cargo_name)
                            <div class="group">
                                <x-buttons.btn class="btn-default group-hover:btn-danger" wire:click="remove_role({{ $cargo_id }})">
                                    <span class="text-sm">{{ $cargo_name }}</span>
                                    <x-bx-x class="w-4 h-4 hidden group-hover:block" />
                                </x-buttons.btn>
                            </div>
                            @empty
                                <span class="text-sm text-yellow-500 italic">{{ __('Sin cargos asociados') }}</span>
                            @endforelse
                        </div>

                        @error( 'cargos' )
                            <div class="text-error">{{$message}}</div>
                        @enderror
                    </div>

                </div>
            </x-fieldset>

            <x-fieldset>
                <div class="grid lg:grid-cols-3 gap-4">

                    <div class="flex flex-col">
                        <legend class="upper-legend">{{__('Sobre sus Permisos')}}</legend>
                        <p class="legend italic">{{__('Permisos asociados al usuario')}}</p>
                    </div>

                    <div class="lg:col-span-2 grid gap-2" x-data="{show_permissions: false}">

                        <div class="flex space-x-2">
                            <div class="w-full">
                                <x-select-two-multiple
                                    name="select_two_add_permission_to_user"
                                    title="Agregar Permiso..."
                                    :options="$this->permissions"
                                    search="selected_two_permission_search"
                                    when_selected="select_permission"
                                    :selected_ids="$selected_two_permission_ids"
                                    search_by="Buscar por nombre"
                                />
                            </div>
                            <x-buttons.btn class="btn-default h-8" x-on:click="show_permissions=!show_permissions">
                                <span class="flex items-center">Mostrar ({{ $this->user->getAllPermissions()->count() }})</span>
                            </x-buttons.btn>
                        </div>

                        <div class="flex flex-wrap gap-2 gap-y-1" x-show="show_permissions" x-cloak>
                            @forelse ($this->user_permissions as $user_permission_id => $user_permission_name)
                            <div class="group">
                                <x-buttons.btn class="btn-default group-hover:btn-danger" wire:click="remove_permission({{ $user_permission_id }})">
                                    <span class="text-sm">{{ $user_permission_name }}</span>
                                    <x-bx-x class="w-4 h-4 hidden group-hover:block" />
                                </x-buttons.btn>
                            </div>
                            @empty
                                <span class="text-sm text-yellow-500 italic">{{ __('Sin permisos asociados') }}</span>
                            @endforelse
                        </div>
                    </div>

                </div>
            </x-fieldset>

            <x-fieldset>
                <div class="grid lg:grid-cols-3 gap-4">

                    <div class="flex flex-col">
                        <legend class="upper-legend">{{__('Cambio de Clave')}}</legend>
                        <p class="legend italic">{{__('Cambio de clave de acceso')}}</p>
                    </div>

                    <div class="lg:col-span-2">
                        <form wire:submit="changePassword">
                            <div class="lg:col-span-2 grid grid-cols-2 gap-4">
                                <x-inputs.password name="update_user_password" label="{{ __('pages.users.attributes.form.password') }}" wire:model="password" autocomplete="new-password" />

                                <x-inputs.password name="update_user_password_confirmation" label="{{ __('pages.users.attributes.form.password_confirmation') }}" wire:model="password_confirmation" autocomplete="new-password" />

                                <div class="col-span-2 flex justify-between items-center">
                                    <x-buttons.btn class="btn-default" wire:click="generatePassword">
                                        {{ __('pages.users.titles.generate_password') }}
                                    </x-buttons.btn>
                                    <x-buttons.submit class="btn-info">
                                        {{ __('pages.users.titles.change_password') }}
                                    </x-buttons.submit>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </x-fieldset>

            <x-fieldset>
                <div class="grid lg:grid-cols-3 gap-4">

                    <div class="flex flex-col">
                        <legend class="upper-legend">{{__('Activar o Desactivar')}}</legend>
                        <p class="legend italic">{{__('Activar o desactivar el usuario')}}</p>
                    </div>

                    <div class="lg:col-span-2 grid grid-cols-2 gap-4">
                        <x-toggle-sm name="update_user_active" label="{{ __('pages.users.attributes.form.active') }}" default="red" wire:model.live="is_active" yes="Activado" not="No Activado" />
                    </div>
                </div>
            </x-fieldset>

        </div>
    </section>
</div>
