<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Blockpc\App\Rules\OnlyKeysFromCollectionRule;
use Blockpc\App\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

final class UpdateUser extends Component
{
    use AlertBrowserEvent;

    protected $listeners = [
        'refresh-update-user' => '$refresh'
    ];

    public User $user;

    public $name;

    public $email;

    public $firstname;

    public $lastname;

    public $role_id;

    public $role_ids;

    public $cargos;

    public function mount()
    {
        $this->authorize('user update');

        $this->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'firstname' => $this->user->profile->firstname,
            'lastname' => $this->user->profile->lastname,
            'role_ids' => $this->user->roles->pluck('id')->toArray(),
            'cargos' => $this->user->roles->pluck('display_name', 'id'),
        ]);
    }

    #[Layout('layouts.backend')]
    #[Title('pages.users.titles.edit')]
    public function render()
    {
        return view('livewire.users.update-user');
    }

    public function save()
    {
        $data = $this->validate();

        $type = 'success';
        $message = '';
        DB::beginTransaction();
        try {

            // Actualizar el usuario
            $this->user->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            // Actualizar el perfil asociado
            $this->user->profile->update([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
            ]);

            DB::commit();
            $message = '';
        } catch(\Throwable $th) {
            Log::error("Error al actualizar los datos de un usuario. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al actualizar los datos de un usuario. Comuníquese con el administrador';
        }

        $this->flash($message, $type);
        $this->redirectRoute('users.table', navigate: true);
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore($this->user->id)],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', Rule::unique('users', 'email')->ignore($this->user->id)],
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ];
    }

    protected function getValidationAttributes()
    {
        return __('pages.users.attributes.form');
    }

    #[Computed()]
    public function roles()
    {
        return Role::query()
            ->when(! current_user()->hasRole('sudo'), function ($query) {
                return $query->whereNotIn('name', ['sudo']);
            })
            ->whereNotIn('id', $this->role_ids)
            ->pluck('display_name', 'id');
    }

    public function agregar_cargo()
    {
        $this->validate([
            'role_id' => ['required', 'integer', new OnlyKeysFromCollectionRule($this->roles)],
        ]);

        $role = Role::find($this->role_id);
        $this->user->assignRole($role->id);


        $this->role_ids = $this->user->roles->pluck('id')->toArray();
        $this->cargos = $this->user->roles->pluck('display_name', 'id');

        $this->alert("Cargo {$role->display_name} agregado correctamente", 'success', 'Nuevo cargo Usuario');
        $this->dispatch('refresh-update-user');
    }

    public function quitar_cargo($role_id)
    {
        $role = Role::find($role_id);

        if ( ! $role ) {
            $this->addError('cargos', "El cargo no existe en el sistema");
            return;
        }

        $this->user->removeRole($role->id);

        $this->role_ids = $this->user->roles->pluck('id')->toArray();
        $this->cargos = $this->user->roles->pluck('display_name', 'id');

        $this->alert("Cargo {$role->display_name} quitado correctamente", 'warning', 'Quitar cargo Usuario');
        $this->dispatch('refresh-update-user');
    }
}
