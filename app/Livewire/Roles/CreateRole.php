<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Role;
use Blockpc\App\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

final class CreateRole extends Component
{
    use AlertBrowserEvent;

    protected $listeners = [
        'show'
    ];

    public $show = false;

    public $name;

    public $display_name;

    public $description;

    public function mount()
    {
        $this->hide();
    }

    public function render()
    {
        return view('livewire.roles.create-role');
    }

    public function save()
    {
        $this->authorize('role create');
        $this->validate();

        $role = null;

        $type = 'success';
        $message = '';
        DB::beginTransaction();
        try {

            $role = Role::create([
                'name' => $this->name,
                'guard_name' => 'web',
                'display_name' => $this->display_name,
                'description' => $this->description,
            ]);

            DB::commit();
            $message = "Un nuevo cargo, {$role->display_name}, ha sido creado en el sistema";

            $this->flash($message, $type);
            $this->redirectRoute('roles.update', ['role' => $role->id], navigate: true);
        } catch(\Throwable $th) {
            Log::error("Error al crear un nuevo cargo en el sistema. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al crear un nuevo cargo en el sistema. Comuníquese con el administrador';

            $this->flash($message, $type);
            $this->redirectRoute('roles.table', navigate: true);
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:50|unique:roles,name',
            'display_name' => 'required|string|min:3|max:64|unique:roles,display_name',
            'description' => 'nullable|string|max:255',
        ];
    }

    protected function getValidationAttributes()
    {
        return __('pages.roles.attributes.form');
    }

    public function show()
    {
        $this->show = true;
    }

    public function hide()
    {
        $this->clearValidation();
        $this->reset();
    }

}
