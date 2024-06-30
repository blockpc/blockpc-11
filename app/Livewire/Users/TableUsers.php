<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

final class TableUsers extends Component
{
    public function mount()
    {
        //
    }

    #[Layout('layouts.backend')]
    #[Title('Tabla Usuarios')]
    public function render()
    {
        return view('livewire.users.table-users');
    }
}
