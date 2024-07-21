<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use Blockpc\App\Models\Role;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

final class TableRoles extends Component
{
    use WithPagination;

    public function mount()
    {
        $this->authorize('role list');
    }

    #[Layout('layouts.backend')]
    #[Title('pages.roles.titles.table')]
    public function render()
    {
        return view('livewire.roles.table-roles');
    }

    #[Computed()]
    public function roles()
    {
        return Role::paginate(10);
    }

    public function create_role()
    {
        $this->dispatch('show')->to('roles.create-role');
    }
}
