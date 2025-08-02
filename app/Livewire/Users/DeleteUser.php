<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\User;
use Blockpc\App\Rules\AreEqualsRule;
use Blockpc\App\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Throwable;

final class DeleteUser extends Component
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

        $user = User::findOrFail($this->user_id);
        $this->username = $user->fullname;
    }

    public function render()
    {
        return view('livewire.users.delete-user');
    }

    public function delete()
    {
        $this->authorize('user delete');

        $this->validate();

        $type = 'success';
        $message = '';
        DB::beginTransaction();
        try {

            $user = User::findOrFail($this->user_id);

            // set is_active to false
            $user->is_active = false;
            $user->save();

            if ($user->profile->image) {
                // delete the image from storage
                Storage::disk('public')->delete($user->profile->image);

                // set image to null
                $user->profile->image = null;
                $user->profile->save();
            }

            $user->delete();

            DB::commit();
            $message = "Usuario {$this->username} eliminado correctamente.";
        } catch (Throwable $th) {
            Log::error("Error al eliminar un usuario. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al eliminar un usuario. Comuníquese con el administrador';
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
