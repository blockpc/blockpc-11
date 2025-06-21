<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Permission;
use App\Models\Role;
use Blockpc\App\Traits\AlertBrowserEvent;
use Blockpc\App\Traits\CustomPaginationTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;
use Throwable;

final class UpdateRole extends Component
{
    use AlertBrowserEvent;
    use CustomPaginationTrait;

    public Role $role;

    #[Locked]
    public $role_id;

    public $display_name;

    public $guard_name;

    public $description;

    public $group_id;

    public $permisos_ids = [];

    public $permissions_role = 0;

    protected $listeners = [
        'refresh-roles' => '$refresh',
    ];

    public function mount()
    {
        $this->authorize('role update');

        $this->startMount();
    }

    #[Layout('layouts.backend')]
    #[Title('pages.roles.titles.edit')]
    public function render()
    {
        return view('livewire.roles.update-role');
    }

    public function updateRole()
    {
        $this->validate();

        $type = 'success';
        $message = '';
        DB::beginTransaction();
        try {

            $role = Role::find($this->role_id);

            $role->update([
                'display_name' => $this->display_name,
                'guard_name' => $this->guard_name,
                'description' => $this->description,
            ]);

            DB::commit();
            $message = '';
        } catch (Throwable $th) {
            Log::error("Error al actualizar un cargo del sistema. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al actualizar un cargo del sistema. Comuníquese con el administrador';
        }

        $this->flash($message, $type);
        $this->redirectRoute('roles.table', navigate: true);
    }

    #[Computed()]
    public function permisos()
    {
        return Permission::query()
            ->when($this->permissions_role, function ($query) {
                $query->whereIn('id', $this->permisos_ids);
            })
            ->when(! current_user()->hasRole('sudo'), function ($query) {
                $query->whereNotIn('key', ['sudo']);
            })
            ->when($this->search, function ($query) {
                $query->whereLike(['display_name'], $this->search);
            })
            ->when($this->group_id, function ($query) {
                $query->where('key', $this->group_id);
            })
            ->paginate($this->paginate);
    }

    #[Computed()]
    public function groups()
    {
        return Permission::query()
            ->when(! current_user()->hasRole('sudo'), function ($query) {
                $query->whereNotIn('key', ['sudo']);
            })
            ->select('key')
            ->groupBy('key')
            ->pluck('key');
    }

    public function asignar_permiso($permiso_id)
    {
        $role = Role::find($this->role_id);
        $permission = Permission::find($permiso_id);
        $role->givePermissionTo($permission->name);

        $this->alert("Permiso {$permission->display_name} asignado correctamente", 'success', 'Permiso Asignado');

        $this->permisos_ids = $role->permissions->pluck('id')->toArray();
        $this->dispatch('refresh-roles')->self();
    }

    public function quitar_permiso($permiso_id)
    {
        $role = Role::find($this->role_id);
        $permission = Permission::find($permiso_id);
        $role->revokePermissionTo($permission->name);

        $this->alert("Permiso {$permission->display_name} eliminado correctamente", 'warning', 'Permiso Eliminado');

        $this->permisos_ids = $role->permissions->pluck('id')->toArray();
        $this->dispatch('refresh-roles')->self();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ];
    }

    private function startMount()
    {
        $this->role_id = $this->role->id;
        $this->display_name = $this->role->display_name;
        $this->guard_name = $this->role->guard_name;
        $this->description = $this->role->description;
        $this->permisos_ids = $this->role->permissions->pluck('id')->toArray();
    }
}
