<div class="mt-4">
    <form wire:submit="restore">
        <div class="grid gap-4">
            <div class="">
                <p class="text-sm">¿Deseas restaurar este cargo?</p>
                <p class="text-sm">El cargo será restaurado.</p>
                <p class="text-sm">Escriba el nombre del cargo a restaurar <span class="text-warning">{{ $current_name }}</span>.</p>
            </div>

            <x-inputs.text name="restore_role_name" label="{{ __('pages.roles.attributes.form.name') }}" wire:model="name" placeholder="{{ $current_name }}" />

            <x-inputs.password name="restore_role_password" label="{{ __('common.password') }}" wire:model="password" />

            <div class="flex justify-end space-x-2">
                <x-links.href class="btn-sm btn-cancel" href="{{ route('roles.table') }}">
                    <span>{{ __('common.cancel') }}</span>
                </x-links.href>
                <x-buttons.submit class="btn-secondary">
                    {{ __('pages.roles.titles.restore') }}
                </x-buttons.submit>
            </div>
        </div>
    </form>
</div>
