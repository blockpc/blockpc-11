<div class="mt-4">
    <form wire:submit="save">
        <div class="grid gap-4">
            <div class="">
                <p class="text-sm">¿Deseas eliminar este cargo?</p>
                <p class="text-sm">El cargo será eliminado lógicamente. Esta acción se puede deshacer.</p>
                <p class="text-sm">Escriba el nombre del cargo a eliminar <span class="text-warning">{{ $current_name }}</span>.</p>
            </div>

            <x-inputs.text name="delete_role_name" label="{{ __('pages.roles.attributes.form.name') }}" wire:model="name" placeholder="{{ $current_name }}" />

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
