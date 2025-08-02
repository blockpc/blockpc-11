<?php

declare(strict_types=1);

namespace App\Livewire\Permissions;

use App\Models\Permission;
use Blockpc\App\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Throwable;

/**
 * permissions.update-permission
 */
final class UpdatePermission extends Component
{
    use AlertBrowserEvent;

    #[Locked]
    public $permission_id;

    public $display_name;

    public $description;

    public function mount()
    {
        $this->authorize('permission update');

        if ($this->permission_id) {
            $permission = Permission::find($this->permission_id);
            $this->display_name = $permission->display_name;
            $this->description = $permission->description;
        }
    }

    public function render()
    {
        return view('livewire.permissions.update-permission');
    }

    public function update()
    {
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
            $message = "El permiso, {$this->display_name}, ha sido actualizado correctamente";
        } catch (Throwable $th) {
            Log::error("Error al actualizar un permiso. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al actualizar un permiso. Comuníquese con el administrador';
        }

        $this->flash($message, $type);
        $this->redirectRoute('permissions.table', navigate: true);
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
}
