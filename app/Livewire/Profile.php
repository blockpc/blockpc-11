<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Actions\Logout;
use App\Models\User;
use Blockpc\App\Rules\AreEqualsRule;
use Blockpc\App\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

final class Profile extends Component
{
    use AlertBrowserEvent;

    public $firstname;

    public $lastname;

    public $email;

    public $photo;

    public $password;

    public $current_password;

    public $password_confirmation;

    public $delete_email;

    public $delete_current_password;

    #[Locked]
    public $user_id;

    #[Locked]
    public User $user;

    public function mount()
    {
        $this->user_id = auth()->id();

        $this->user = current_user();
        $this->email = $this->user->email;
        $this->firstname = $this->user->profile->firstname;
        $this->lastname = $this->user->profile->lastname;
    }

    #[Layout('layouts.backend')]
    #[Title('Perfil Usuario')]
    public function render()
    {
        return view('livewire.profile');
    }

    public function updateProfile()
    {
        $validated = $this->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user_id)],
        ]);

        $type = 'success';
        $message = '';
        DB::beginTransaction();
        try {

            $user = User::find($this->user_id);

            $user->fill([
                'email' => $validated['email'],
            ]);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            $user->profile->fill([
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
            ]);

            if ($this->photo) {
                $user->profile->image = $this->savePhoto();
            }

            $user->profile->save();

            DB::commit();
            $message = 'El perfil se ha actualizado correctamente';
        } catch (\Throwable $th) {
            Log::error("Error al actualizar el perfil de un usuario. {$th->getMessage()} | {$th->getFile()} | {$th->getLine()}");
            DB::rollback();
            $type = 'error';
            $message = 'Error al actualizar el perfil de un usuario. Comuníquese con el administrador';
        }

        $this->alert($message, $type, 'Perfil Usuario');
    }

    public function updatePassword()
    {
        $validated = $this->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');
    }

    public function deleteAccount(Logout $logout)
    {
        $validated = $this->validate([
            'delete_email' => ['required', 'string', (new AreEqualsRule($this->user->email))],
            'delete_current_password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }

    public function savePhoto()
    {
        // Guarda la foto en el almacenamiento público
        return $this->photo->store('photos', 'public');
    }
}
