<div>
    <x-page-header titulo="pages.roles.titles.create" icon="heroicon-s-users">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
            <x-links.href class="btn-sm btn-default" href="{{ route('roles.table') }}">
                <span>{{__('pages.roles.titles.link')}}</span>
            </x-links.href>
        </x-slot>
    </x-page-header>

    <section class="mt-2 mx-auto w-full">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-2 gap-4 mt-4">

                <x-fieldset title="Sobre el Cargo">
                    <div class="grid gap-4">
                        <x-inputs.text name="create_role_name" label="{{ __('pages.roles.attributes.form.name') }}" wire:model="name" autocomplete="username" title="Alias del cargo" required />

                        <x-inputs.text name="create_display_name_name" label="{{ __('pages.roles.attributes.form.display_name') }}" wire:model="display_name" title="Nombre del cargo" autocomplete="username" required />

                        <x-inputs.textarea class="text-xs" name="create_description_name" label="{{ __('pages.roles.attributes.form.description') }}" wire:model="description" title="Descripción del cargo" />
                    </div>
                </x-fieldset>

                <x-fieldset title="Sobre sus Permisos">
                    <div class="grid gap-4">
                        {{-- <div class="grid grid-cols-2 gap-4">
                            @foreach ($permissions as $permission)
                                <div>
                                    <x-inputs.checkbox name="create_permission_{{ $permission->id }}" label="{{ $permission->display_name }}" wire:model="permissions.{{ $permission->id }}" />
                                </div>
                            @endforeach
                        </div> --}}
                    </div>
                </x-fieldset>


                <div class="col-span-2">
                    <div class="flex justify-end space-x-2">
                        <x-buttons.cancel wire:click="hide" />
                        <x-buttons.submit class="btn-primary">
                            {{ __('pages.roles.titles.create') }}
                        </x-buttons.submit>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
