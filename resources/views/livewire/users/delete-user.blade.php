<div class="mt-4">
    <form wire:submit.prevent="delete">
        <div class="grid gap-4">
            <div class="">
                <p class="text-sm">¿Deseas eliminar este usuario?</p>
                <p class="text-sm">El usuario será eliminado lógicamente. Esta acción se puede deshacer.</p>
                <p class="text-sm">Escriba el nombre del usuario a eliminar <span class="text-warning">{{ $username }}</span>.</p>
            </div>
            <x-inputs.text name="delete_user_name" label="{{ __('Nombre del Usuario') }}" wire:model="name" />
            <x-inputs.password name="delete_user_password" label="{{ __('Clave') }}" wire:model="password" />
        </div>
        <div class="flex justify-end space-x-2 mt-4">
            <x-buttons.btn class="btn-cancel" wire:click="$dispatch('closeModal')">
                {{ __('common.cancel') }}
            </x-buttons.btn>
            <x-buttons.submit class="btn-danger">
                {{ __('common.delete') }}
            </x-buttons.submit>
        </div>
    </form>
</div>
