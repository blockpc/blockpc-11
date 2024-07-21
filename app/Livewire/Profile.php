<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Actions\Logout;
use App\Models\User;
use Blockpc\App\Rules\AreEqualsRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

final class Profile extends Component
{
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

    public function mount()
    {
        $this->user_id = auth()->id();

        $this->email = current_user()->email;
        $this->firstname = current_user()->profile->firstname;
        $this->lastname = current_user()->profile->lastname;
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

        $user = User::find($this->user_id);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $user->profile->fill($validated);

        if ($this->photo) {
            $user->profile->image = $this->savePhoto();
        }

        $user->profile->save();
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
            'delete_email' => ['required', 'string', (new AreEqualsRule(current_user()->email))],
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
