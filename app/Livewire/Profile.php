<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

final class Profile extends Component
{
    public function mount()
    {
        //
    }

    #[Layout('layouts.backend')]
    #[Title('Perfil Usuario')]
    public function render()
    {
        return view('livewire.profile');
    }
}
