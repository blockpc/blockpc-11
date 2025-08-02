<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Role;
use Blockpc\App\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Throwable;

final class RestoreRole extends Component
{
    use AlertBrowserEvent;

    #[Locked]
    public $role_id;

    #[Locked]
    public $current_name;

    public $name;

    public $password;

    public function mount()
    {
        $this->authorize('role restore');

        $role = Role::onlyTrashed()->findOrFail($this->role_id);
        $this->current_name = $role->display_name;
    }

    public function render()
    {
        return view('livewire.roles.restore-role');
    }

    public function restore()
    {
        $this->validate();

        $type = 'success';
        $message = '';
        DB::beginTransaction();
        try {
            $role = Role::onlyTrashed()->findOrFail($this->role_id);
            $role->restore();

            DB::commit();
            $message = "Cargo {$this->current_name} fue restaurado correctamente";
        } catch (Throwable $th) {
            Log::error("Error al restaurar un cargo. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al restaurar un cargo. Comuníquese con el administrador';
        }

        return redirect()->route('roles.table')->with($type, $message);
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|same:current_name',
            'password' => 'required|string|current_password',
        ];
    }
}
