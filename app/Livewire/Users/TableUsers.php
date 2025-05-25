<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\User;
use Blockpc\App\Traits\CustomPaginationTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

final class TableUsers extends Component
{
    use CustomPaginationTrait;

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
        return User::with('profile')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->when(! current_user()->hasRole('sudo'), function ($query) {
                $query->whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'sudo');
                });
            })
            ->search($this->search)
            ->orderBy('profiles.firstname')
            ->paginate($this->paginate);
    }

    public function create_user()
    {
        $this->dispatch('show')->to(CreateUser::class);
    }
}
