<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

final class Home extends Component
{
    public function mount()
    {
        //
    }

    #[Layout('layouts.frontend')]
    #[Title('Home')]
    public function render()
    {
        return view('livewire.home');
    }
}
