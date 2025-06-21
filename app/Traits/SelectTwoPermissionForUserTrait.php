<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Permission;
use Livewire\Attributes\Computed;

trait SelectTwoPermissionForUserTrait
{
    public $user_permissions;

    public $selected_two_permission_ids;

    public $selected_two_permission_search = '';

    public function bootSelectTwoPermissionForUserTrait()
    {
        $this->load_permissions();
    }

    #[Computed()]
    public function permissions()
    {
        $query = Permission::query();

        $query->when($this->selected_two_permission_search, function ($query) {
            $query->whereLike(['name', 'display_name'], $this->selected_two_permission_search);
        });

        $query->when(! current_user()->hasRole('sudo'), function ($query) {
            $query->whereNot('name', 'super admin');
        });

        return $query->pluck('display_name', 'id');
    }

    public function select_permission($id)
    {
        if (! $this->selected_two_permission_ids->contains($id)) {
            $permiso = Permission::find($id);
            $this->user->givePermissionTo($permiso);
            $this->load_permissions();
        }
        $this->search_permission = '';
    }

    public function remove_permission($id)
    {
        if ($this->selected_two_permission_ids->contains($id)) {
            $permiso = Permission::find($id);
            $this->user->revokePermissionTo($permiso);
            $this->load_permissions();
        }
    }

    private function load_permissions()
    {
        $this->user_permissions = $this->user->getAllPermissions()->pluck('display_name', 'id');
        $this->selected_two_permission_ids = $this->user->getAllPermissions()->pluck('id');
    }
}