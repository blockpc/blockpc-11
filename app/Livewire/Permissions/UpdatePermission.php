<?php

declare(strict_types=1);

namespace App\Livewire\Permissions;

use App\Models\Permission;
use Blockpc\App\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * permissions.update-permission
 */
final class UpdatePermission extends Component
{
    use AlertBrowserEvent;

    public $show = false;

    #[Locked]
    public $permission_id;

    public $display_name;

    public $description;

    public function mount()
    {
        $this->hide();
    }

    public function render()
    {
        return view('livewire.permissions.update-permission');
    }

    public function update()
    {
        $this->authorize('permission update');
        $this->validate();

        $type = 'success';
        $message = '';
        DB::beginTransaction();
        try {

            $permission = Permission::find($this->permission_id);
            $permission->update([
                'display_name' => $this->display_name,
                'description' => $this->description,
            ]);

            DB::commit();
            $message = 'Un permiso fue actualizado correctamente';
            $this->hide();
            $this->dispatch('permissionsUpdated');
        } catch (\Throwable $th) {
            Log::error("Error al actualizar un permiso. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al actualizar un permiso. Comuníquese con el administrador';
        }

        $this->alert($message, $type, 'Actualizar Permiso');
    }

    protected function rules()
    {
        return [
            'display_name' => 'required|string|max:255|unique:permissions,display_name,'.$this->permission_id.',id',
            'description' => 'required|string|max:255',
        ];
    }

    protected function getValidationAttributes()
    {
        return [
            'display_name' => 'nombre a mostrar',
            'description' => 'descripción',
        ];
    }

    #[On('show')]
    public function show($permission_id)
    {
        $this->show = true;
        $this->permission_id = $permission_id;

        $permission = Permission::find($permission_id);
        $this->display_name = $permission->display_name;
        $this->description = $permission->description;
    }

    public function hide()
    {
        $this->clearValidation();
        $this->reset();
    }
}
