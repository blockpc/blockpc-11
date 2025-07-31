<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

final class Home extends Component
{
    #[Layout('layouts.frontend')]
    #[Title('Inicio')]
    public function render()
    {
        return view('livewire.home');
    }
}
