<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Blockpc\App\Rules\OnlyKeysFromCollectionRule;
use Blockpc\App\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

final class CreateUser extends Component
{
    use AlertBrowserEvent;
    use WithFileUploads;

    protected $listeners = [
        'show',
    ];

    public $show = false;

    public $photo;

    public string $name;

    public string $email;

    public string $firstname;

    public string $lastname;

    public int $role_id;

    public function mount()
    {
        $this->hide();
    }

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

            // Crear el usuario en la base de datos con la propiedad mail y un name falso
            $user = User::create([
                'email' => $this->email,
                'name' => $this->name,
                'password' => bcrypt('password'),
            ]);

            // crear el perfil del usuario
            $user->profile()->create([
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'image' => $this->photo ? $this->savePhoto() : null,
            ]);

            // Asignar el rol al usuario
            $user->assignRole($this->role_id);

            DB::commit();
            $message = 'Usuario creado correctamente';
        } catch (\Throwable $th) {
            Log::error("Error al crear un nuevo usuario. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al crear un nuevo usuario. Comuníquese con el administrador';
        }

        $this->flash($message, $type);
        $this->redirectRoute('users.table', navigate: true);
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|max:255|email:rfc,dns|unique:users,email',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'role_id' => ['required', new OnlyKeysFromCollectionRule($this->roles())],
            'photo' => 'nullable|image|max:1024',
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
            ->pluck('display_name', 'id');
    }

    public function savePhoto()
    {
        return $this->photo->store('photos', 'public');
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
