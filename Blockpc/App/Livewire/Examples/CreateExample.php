<?php

declare(strict_types=1);

namespace Blockpc\App\Livewire\Examples;

use Blockpc\App\Traits\AlertBrowserEvent;
use Livewire\Component;

/**
 * create-example
 */
final class CreateExample extends Component
{
    use AlertBrowserEvent;

    public $title;

    public $body;

    public function render()
    {
        return view('blockpc::livewire.examples.create-example');
    }

    public function save()
    {
        $this->validate();

        // Aquí iría la lógica para guardar el ejemplo

        $this->alert('Ejemplo creado exitosamente.', 'success', 'Ejemplo Creado');

        $this->dispatch('closeModal')->to('custom-modal');
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ];
    }
}
