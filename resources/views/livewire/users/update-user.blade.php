<div>
    <x-page-header titulo="pages.users.titles.edit" icon="heroicon-s-users">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
            <x-links.href class="btn-sm btn-default" href="{{ route('users.table') }}">
                <span>{{__('pages.users.titles.table')}}</span>
            </x-links.href>
        </x-slot>
    </x-page-header>

    <section class="mt-2 mx-auto w-full">
        <form wire:submit="save">
            <div class="grid gap-8">

                {{-- Sobre el usuario --}}
                <div class="grid md:grid-cols-3 gap-4">

                    <div class="flex flex-col md:space-y-2">
                        <legend class="uppercase tracking-wide text-base">{{__('Sobre el Usuario')}}</legend>
                        <p class="text-sm font-light">{{__('Informacióm asociada al usuario')}}</p>
                    </div>

                    <div class="md:col-span-2 grid grid-cols-2 gap-4">
                            <x-inputs.text name="create_user_firstname" label="{{ __('pages.users.attributes.form.firstname') }}" wire:model="firstname" required />

                            <x-inputs.text name="create_user_lastname" label="{{ __('pages.users.attributes.form.lastname') }}" wire:model="lastname" required />

                            <div class="col-span-2">
                                <x-inputs.text name="create_user_email" label="{{ __('pages.users.attributes.form.email') }}" wire:model="email" autocomplete="username" required />
                            </div>

                            <x-inputs.text name="create_user_name" label="{{ __('pages.users.attributes.form.name') }}" wire:model="name" autocomplete="username" required />

                            <div class="col-span-2 flex justify-end space-x-2">
                                <x-links.href class="btn-sm btn-cancel" href="{{ route('roles.table') }}">
                                    <span>{{ __('common.cancel') }}</span>
                                </x-links.href>
                                <x-buttons.submit class="btn-success">
                                    {{ __('pages.users.titles.edit') }}
                                </x-buttons.submit>
                            </div>
                    </div>

                </div>

                {{-- Sus Cargos --}}
                <div class="grid md:grid-cols-3 gap-4">

                    <div class="flex flex-col md:space-y-2">
                        <legend class="uppercase tracking-wide text-base">{{__('Sobre sus Cargos')}}</legend>
                        <p class="text-sm font-light">{{__('Cargos asociados al usuario')}}</p>
                    </div>

                    <div class="md:col-span-2 grid gap-4">

                        {{-- <div class="flex space-x-2">
                            <x-inputs.select class="flex-1" name="role" :options="$this->roles" wire:model="role_id" required />

                            <x-buttons.btn class="btn-default mb-auto" wire:click="agregar_cargo">
                                <span>{{__('pages.users.titles.add_role')}}</span>
                            </x-buttons.btn>
                        </div> --}}

                        <x-select-two-only-select
                            name="select_two_add_role_to_user"
                            title="Buscar cargo"
                            :options="$this->allRoles"
                            search="selected_two_role_search"
                            click="select_option"
                            selected_name="{{ $selected_two_role_name }}"
                            selected_id="{{ $selected_two_role_id }}"
                            search_by="Buscar por nombre"
                        />

                        <div class="flex space-x-2">
                            @foreach ($this->userRoles as $cargo_id => $cargo_name)
                            <div class="group">
                                <x-buttons.btn class="btn-action group-hover:btn-danger" wire:click="remove_option({{ $cargo_id }})">
                                    <span class="text-sm">{{ $cargo_name }}</span>
                                    <x-bx-x class="w-4 h-4 hidden group-hover:block" />
                                </x-buttons.btn>
                            </div>
                            @endforeach
                        </div>

                        @error( 'cargos' )
                            <div class="text-error">{{$message}}</div>
                        @enderror
                    </div>

                </div>

                {{-- Sus permisos --}}
                <div class="grid md:grid-cols-3 gap-4">

                    <div class="flex flex-col md:space-y-2">
                        <legend class="uppercase tracking-wide text-base">{{__('Sobre sus Permisos')}}</legend>
                        <p class="text-sm font-light">{{__('Permisos asociados al usuario')}}</p>
                    </div>

                    <div class="md:col-span-2 grid gap-4"></div>

                </div>

                {{-- Cambio de claver --}}
                <div class="grid md:grid-cols-3 gap-4">

                    <div class="flex flex-col md:space-y-2">
                        <legend class="uppercase tracking-wide text-base">{{__('Cambio de Clave')}}</legend>
                        <p class="text-sm font-light">{{__('Cambio de clave de acceso')}}</p>
                    </div>

                    <div class="md:col-span-2 grid grid-cols-2 gap-4">
                        {{-- <x-inputs.password name="create_user_password" label="{{ __('pages.users.attributes.form.password') }}" wire:model="password" autocomplete="new-password" required />

                        <x-inputs.password name="create_user_password_confirmation" label="{{ __('pages.users.attributes.form.password_confirmation') }}" wire:model="password_confirmation" autocomplete="new-password" required /> --}}
                    </div>
                </div>

                {{-- Activar o desactivar usuario --}}
                <div class="grid md:grid-cols-3 gap-4">

                    <div class="flex flex-col md:space-y-2">
                        <legend class="uppercase tracking-wide text-base">{{__('Activar o Desactivar')}}</legend>
                        <p class="text-sm font-light">{{__('Activar o desactivar el usuario')}}</p>
                    </div>

                    <div class="md:col-span-2 grid grid-cols-2 gap-4">
                        {{-- <x-inputs.switch name="create_user_active" label="{{ __('pages.users.attributes.form.active') }}" wire:model="active" /> --}}
                    </div>
                </div>

            </div>
        </form>
    </section>
</div>
