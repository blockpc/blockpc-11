<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\User;
use App\Traits\SelectTwoRoleForUserTrait;
use Blockpc\App\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

final class UpdateUser extends Component
{
    use AlertBrowserEvent;
    use SelectTwoRoleForUserTrait;

    protected $listeners = [
        'refresh-update-user' => '$refresh',
    ];

    public User $user;

    public $name;

    public $email;

    public $firstname;

    public $lastname;

    public function mount()
    {
        $this->authorize('user update');

        $this->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'firstname' => $this->user->profile->firstname,
            'lastname' => $this->user->profile->lastname,
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
        } catch (\Throwable $th) {
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
}
