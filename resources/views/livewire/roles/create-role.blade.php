<div class="mt-4">
    <form class="w-full" wire:submit.prevent="save">
        <div class="grid gap-4">

            <x-inputs.text name="create_role_name" label="{{ __('pages.roles.attributes.form.name') }}" wire:model="name" autocomplete="username" title="Alias del cargo" required />

            <x-inputs.text name="create_display_name_name" label="{{ __('pages.roles.attributes.form.display_name') }}" wire:model="display_name" title="Nombre del cargo" autocomplete="username" required />

            <x-inputs.textarea class="text-xs" name="create_description_name" label="{{ __('pages.roles.attributes.form.description') }}" wire:model="description" title="Descripción del cargo" />

            <div class="flex justify-end space-x-2">
                <x-links.href class="btn-sm btn-cancel" href="{{ route('roles.table') }}">
                    <span>{{ __('common.cancel') }}</span>
                </x-links.href>
                <x-buttons.submit class="btn-primary">
                    {{ __('pages.roles.titles.create') }}
                </x-buttons.submit>
            </div>
        </div>
    </form>

</div>
