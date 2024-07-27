<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Role;
use Blockpc\App\Traits\CustomPaginationTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

final class TableRoles extends Component
{
    use CustomPaginationTrait;

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
        return Role::whereLike(['display_name', 'description'], $this->search)
            ->paginate($this->paginate);
    }

    public function create_role()
    {
        $this->dispatch('show')->to('roles.create-role');
    }
}
