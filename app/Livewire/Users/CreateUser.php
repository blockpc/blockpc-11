<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\User;
use Blockpc\App\Models\Role;
use Blockpc\App\Rules\OnlyKeysFromCollectionRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * /sistema/usuarios/crear
 * create-user
 */
final class CreateUser extends Component
{
    use WithFileUploads;

    public $photo;
    public string $name;
    public string $email;
    public string $firstname;
    public string $lastname;
    public int $role_id;

    public function mount()
    {
        $this->authorize('user create');
    }

    #[Layout('layouts.backend')]
    #[Title('pages.users.titles.create')]
    public function render()
    {
        return view('livewire.users.create-user');
    }

    public function save()
    {
        $this->authorize('user create');
        $this->validate();

        $type = 'success';
        $message = '';
        DB::beginTransaction();
        try {

            # Crear el usuario en la base de datos con la propiedad mail y un name falso
            $user = User::create([
                'email' => $this->email,
                'name' => $this->name,
                'password' => bcrypt('password')
            ]);

            # crear el perfil del usuario
            $user->profile()->create([
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'image' => $this->photo ? $this->savePhoto() : null
            ]);

            # Asignar el rol al usuario
            $user->assignRole($this->role_id);

            DB::commit();
            $message = 'Usuario creado correctamente';
        } catch(\Throwable $th) {
            Log::error("Error al crear un nuevo usuario. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al crear un nuevo usuario. Comuníquese con el administrador';
        }

        return redirect()->route('users.table')->with($type, $message);
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'role_id' => ['required', new OnlyKeysFromCollectionRule($this->roles)],
            'photo' => 'nullable|image|max:1024'
        ];
    }

    #[Computed()]
    public function roles()
    {
        return Role::query()
            ->when(!current_user()->hasRole('sudo'), function($query) {
                return $query->where('name', '!=', 'sudo');
            })
            ->pluck('display_name', 'id');
    }

    public function savePhoto()
    {
        // Guarda la foto en el almacenamiento público
        return $this->photo->store('photos', 'public');
    }


}
