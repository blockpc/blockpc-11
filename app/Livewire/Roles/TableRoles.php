<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Role;
use Blockpc\App\Livewire\CustomModal;
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
        return Role::withCount('permissions')
            ->when($this->soft_deletes, function ($query) {
                $query->onlyTrashed();
            })
            ->search($this->search)
            ->paginate($this->paginate);
    }

    public function create_role()
    {
        $this->dispatch('openModal', 'roles.create-role', 'pages.roles.titles.create')->to(CustomModal::class);
    }

    public function role_delete($role_id)
    {
        $this->dispatch('openModal', 'roles.delete-role', 'pages.roles.titles.delete', ['role_id' => $role_id])->to(CustomModal::class);
    }

    public function role_restore($role_id)
    {
        $this->dispatch('openModal', 'roles.restore-role', 'pages.roles.titles.restore', ['role_id' => $role_id])->to(CustomModal::class);
    }
}
