<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\User;
use Blockpc\App\Rules\AreEqualsRule;
use Blockpc\App\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Locked;
use Livewire\Component;

final class RestoreUser extends Component
{
    use AlertBrowserEvent;

    #[Locked]
    public $user_id;

    public string $username = '';

    public $name;
    public $password;

    public function mount($user_id)
    {
        $this->user_id = $user_id;

        $user = User::onlyTrashed()->findOrFail($this->user_id);
        $this->username = $user->fullname;
    }

    public function render()
    {
        return view('livewire.users.restore-user');
    }

    public function restore()
    {
        $this->authorize('user restore');

        $this->validate();

        $type = 'success';
        $message = '';
        DB::beginTransaction();
        try {
            $user = User::onlyTrashed()->findOrFail($this->user_id);

            // Restore the user
            $user->restore();

            DB::commit();
            $message = "Usuario {$this->username} restaurado correctamente.";
        } catch(\Throwable $th) {
            Log::error("Error al restaurar un usuario. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al restaurar un usuario. Comuníquese con el administrador';
        }

        $this->dispatch('closeModal');
        $this->flash($message, $type);
        $this->redirectRoute('users.table', navigate: true);
    }

    protected function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', new AreEqualsRule($this->username, 'El nombre del usuario no es correcto')],
            'password' => ['required', 'current_password:web'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'El nombre del usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.current_password' => 'La contraseña actual es incorrecta.',
        ];
    }
}
