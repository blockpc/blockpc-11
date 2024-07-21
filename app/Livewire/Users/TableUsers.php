<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

final class TableUsers extends Component
{
    use WithPagination;

    public function mount()
    {
        $this->authorize('user list');
    }

    #[Layout('layouts.backend')]
    #[Title('Tabla Usuarios')]
    public function render()
    {
        return view('livewire.users.table-users');
    }

    #[Computed()]
    public function users()
    {
        return User::with('profile')->paginate(10);
    }
}
