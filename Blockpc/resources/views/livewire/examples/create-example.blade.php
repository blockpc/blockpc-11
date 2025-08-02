<div>
    <form wire:submit.prevent="save">
        <div class="grid gap-4 mt-4">
            <x-inputs.text label="Titulo" name="create_example_title" title="Titulo" wire:model="title" />
            <x-inputs.textarea label="Mensaje" name="create_example_body" title="Mensaje" wire:model="body" />
            <div class="text-right">
                <x-buttons.submit class="btn-info" title="Crear Ejemplo">
                    <span>Crear Ejemplo</span>
                </x-buttons.submit>
            </div>
        </div>
    </form>
</div>
