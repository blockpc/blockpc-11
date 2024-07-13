<?php

use App\Models\User;
use App\Models\Profile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state([
    'name' => '',
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'name' => ['required', 'string', 'max:255', 'unique:'.User::class],
    'firstname' => ['required', 'string', 'max:255'],
    'lastname' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);

    $user = new User;
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->password = $validated['password'];
    $user->save();

    $profile = new Profile;
    $profile->user_id = $user->id;
    $profile->firstname = $validated['firstname'];
    $profile->lastname = $validated['lastname'];
    $profile->save();

    event(new Registered($user));

    Auth::login($user);

    $this->redirect(route('dashboard', absolute: false), navigate: true);
};

?>

<div>
    <form wire:submit="register">
        <x-inputs.text name="name" label="pages.users.create.form.name" wire:model="name" required autofocus autocomplete="name" />
        <div class="mt-4">
        <x-inputs.text name="firstname" label="pages.users.create.form.firstname" wire:model="firstname" required autofocus autocomplete="name" />
        </div>

        <div class="mt-4">
        <x-inputs.text name="lastname" label="pages.users.create.form.lastname" wire:model="lastname" required autofocus autocomplete="name" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('pages.users.create.form.email')" />
            <x-text-input wire:model="email" id="email" class="input input-sm" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('pages.users.create.form.password')" />

            <x-text-input wire:model="password" id="password" class="input input-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('pages.users.create.form.confirmed_password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="input input-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>

@foreach ($errors->all() as $error)
<div class="pl-6">
    <li class=" list-disc">{{ $error }}</li>
</div>
@endforeach
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm hover:text-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
