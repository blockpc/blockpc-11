<div>
    <x-modal-small class="w/full md:w-1/2 border border-blue-500">
        <x-slot name="titulo">
            {{ __('pages.permissions.titles.edit') }}
        </x-slot>
        <div class="pt-2">
            <form wire:submit="update">
                <div class="grid gap-4">
                    <x-inputs.text label="{{ __('pages.permissions.edit.form.display_name') }}" name="edit_permission_display_name" wire:model="display_name" />

                    <x-inputs.textarea label="{{ __('pages.permissions.edit.form.description') }}" name="edit_permission_description" wire:model="description" />

                    <div class="flex justify-end space-x-2">
                        <x-buttons.btn type="button" class="btn-cancel" wire:click="hide">
                            <span>{{ __('common.cancel') }}</span>
                        </x-buttons.btn>
                        <x-buttons.submit class="btn-success">
                            <span>{{ __('pages.permissions.titles.edit') }}</span>
                        </x-buttons.submit>
                    </div>
                </div>
            </form>
        </div>
    </x-modal-small>
</div>
