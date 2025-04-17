<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Role;
use Livewire\Attributes\Computed;

trait SelectTwoRoleForUserTrait
{

    public $selected_two_role_search;

    public $selected_two_role_id;

    public $selected_two_role_name;

    #[Computed()]
    public function allRoles()
    {
        return Role::query()
            ->when(! current_user()->hasRole('sudo'), function ($query) {
                return $query->whereNotIn('name', ['sudo']);
            })
            ->when($this->user->roles, function ($query) {
                return $query->whereNotIn('id', $this->user->roles->pluck('id')->toArray());
            })
            ->when($this->selected_two_role_search, function ($query) {
                return $query->whereLike(['name', 'display_name'], $this->selected_two_role_search);
            })
            ->pluck('display_name', 'id');
    }

    #[Computed()]
    public function userRoles()
    {
        return $this->user->roles->pluck('display_name', 'id');
    }

    public function select_option($role_id = null)
    {
        $role = Role::find($role_id);

        if ( ! $role) {
            return;
        }

        if ( !$this->user->hasRole($role_id)) {
            $this->user->assignRole($role_id);
            $this->selected_two_role_search = null;
            $this->selected_two_role_id = null;
            $this->selected_two_role_name = null;

            $this->alert("Cargo {$role->display_name} agregado correctamente", 'success', 'Nuevo cargo Usuario');
            $this->dispatch('refresh-update-user');
        }
    }

    public function remove_option($role_id = null)
    {
        $role = Role::find($role_id);

        if ( ! $role) {
            return;
        }

        if ( $this->user->hasRole($role_id)) {
            $this->user->removeRole($role_id);
            $this->selected_two_role_search = null;
            $this->selected_two_role_id = null;
            $this->selected_two_role_name = null;

            $this->alert("Cargo {$role->display_name} quitado correctamente", 'warning', 'Quitar cargo Usuario');
            $this->dispatch('refresh-update-user');
        }
    }

}