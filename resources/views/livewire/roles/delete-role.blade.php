<div>
    <x-modal-small class="w/full md:w-1/2 border border-red-500">
        <x-slot name="titulo">
            {{ __('pages.roles.titles.delete') }}
        </x-slot>
        <div class="pt-2">
            <form wire:submit="save">
                <div class="grid gap-8">
                    <div class="text-center">
                        <p>Escriba el nombre del cargo a eliminar.</p>
                        <p class="italic">{{ $current_name }}</p>
                    </div>

                    <x-inputs.text name="delete_role_name" label="{{ __('pages.roles.attributes.form.name') }}" wire:model="name" readonly placeholder="{{ $current_name }}" />

                    <x-inputs.password name="delete_role_password" label="{{ __('common.password') }}" wire:model="password" placeholder="Clave" />

                    <div class="flex justify-end space-x-2">
                        <x-links.href class="btn-sm btn-cancel" href="{{ route('roles.table') }}">
                            <span>{{ __('common.cancel') }}</span>
                        </x-links.href>
                        <x-buttons.submit class="btn-danger">
                            {{ __('pages.roles.titles.delete') }}
                        </x-buttons.submit>
                    </div>
                </div>
            </form>
        </div>
    </x-modal-small>
</div>
