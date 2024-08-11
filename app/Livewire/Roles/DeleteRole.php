<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Role;
use Blockpc\App\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Locked;
use Livewire\Component;

final class DeleteRole extends Component
{
    use AlertBrowserEvent;

    protected $listeners = [
        'show'
    ];

    public $show = false;

    #[Locked]
    public $role_id;

    #[Locked]
    public $current_name;

    public $name;

    public $password;

    public function mount()
    {
        $this->hide();
    }

    public function render()
    {
        return view('livewire.roles.delete-role');
    }

    public function save()
    {
        $this->validate();

        $type = 'success';
        $message = '';
        DB::beginTransaction();
        try {

            $role = Role::find($this->role_id);
            $role->delete();

            DB::commit();
            $message = 'Role eliminado correctamente';
        } catch(\Throwable $th) {
            Log::error("Error al eliminar un role. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al eliminar un role. Comuníquese con el administrador';
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

    public function show($role_id)
    {
        $this->show = true;
        $this->role_id = $role_id;

        $role = Role::find($role_id);
        $this->current_name = $role->display_name;
    }

    public function hide()
    {
        $this->clearValidation();
        $this->reset();
    }

}
