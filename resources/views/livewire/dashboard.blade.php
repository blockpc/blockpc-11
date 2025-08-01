<div>
    <x-page-header titulo="pages.dashboard.titles.link" icon="bx-layout">
        <x-slot name="buttons"></x-slot>
    </x-page-header>

    <section class="mt-2 mx-auto w-full">

        <div class="grid grid-cols-4 gap-4">
            <div class="min-w-64 min-h-32 p-4 border border-blue-500 shadow-lg rounded-md m-4">
                <div class="mb-4">
                    <h2 class="font-semibold mb-2">Create Example</h2>
                    <p class="text-xs">Este es un ejemplo del modal create example.</p>
                </div>
                <div>
                    <button wire:click="$dispatch('openModal', {
                        view: 'create-example',
                        title: 'Crear Ejemplo'
                    })" class="btn-sm btn-info">
                        Crear Ejemplo
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>
