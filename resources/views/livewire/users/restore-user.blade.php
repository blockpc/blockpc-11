<div class="mt-4">
    <form wire:submit.prevent="restore">
        <div class="grid gap-4">
            <div class="">
                <p class="text-sm">¿Deseas restaurar este usuario?</p>
                <p class="text-sm">El usuario será restaurado pero no activado.</p>
                <p class="text-sm">Escriba el nombre del usuario a restaurar <span class="text-warning">{{ $username }}</span>.</p>
            </div>
            <x-inputs.text name="delete_user_name" label="{{ __('Nombre del Usuario') }}" wire:model="name" />
            <x-inputs.password name="delete_user_password" label="{{ __('Clave') }}" wire:model="password" />
        </div>
        <div class="flex justify-end space-x-2 mt-4">
            <x-buttons.btn class="btn-cancel" wire:click="$dispatch('closeModal')">
                {{ __('common.cancel') }}
            </x-buttons.btn>
            <x-buttons.submit class="btn-secondary">
                {{ __('common.restore') }}
            </x-buttons.submit>
        </div>
    </form>
</div>
