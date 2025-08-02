<?php

declare(strict_types=1);

namespace Blockpc\App\Livewire;

use Livewire\Component;

/**
 * custom-modal
 */
final class CustomModal extends Component
{
    public $show = false;

    public $view = null; // vista que se renderiza dentro del modal

    public $title = null; // título del modal

    public $params = []; // parámetros que se le pasan a la vista

    protected $listeners = ['openModal', 'closeModal'];

    public function openModal(?string $view = null, ?string $title = null, array $params = [])
    {
        $this->view = $view;
        $this->title = $title;
        $this->params = $params;
        $this->show = true;
    }

    public function closeModal()
    {
        $this->reset(['show', 'view', 'title', 'params']);
    }

    public function render()
    {
        return view('blockpc::livewire.custom-modal');
    }
}
