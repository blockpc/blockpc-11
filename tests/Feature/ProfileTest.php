<?php

use App\Livewire\Profile;
use Livewire\Livewire;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->user = new_user();
});

// ProfileTest

test('profile page is displayed', function () {
    $this->actingAs($this->user);

    $response = $this->get('/profile');

    $response->assertOk();
});

it('profile page contains properties and methods', function ()
{
    $this->actingAs($this->user);

    Livewire::test(Profile::class)
        ->assertMethodWiredToForm('updateProfile')
        ->assertPropertyWired('firstname')
        ->assertPropertyWired('lastname')
        ->assertPropertyWired('email')
        ->assertPropertyWired('photo')
        ->assertMethodWiredToForm('updatePassword')
        ->assertPropertyWired('password')
        ->assertPropertyWired('current_password')
        ->assertPropertyWired('password_confirmation');
});

test('profile information can be updated', function () {

    $this->actingAs($this->user);

    $component = Livewire::test(Profile::class)
        ->set('firstname', 'Test')
        ->set('lastname', 'User')
        ->set('email', 'test@example.com')
        ->call('updateProfile');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    $this->user->refresh();

    $this->assertSame('Test User', $this->user->name);
    $this->assertSame('test@example.com', $this->user->email);
    $this->assertNull($this->user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {

    $this->actingAs($this->user);

    $component = Livewire::test(Profile::class)
        ->set('firstname', 'Test')
        ->set('lastname', 'User')
        ->set('email', $this->user->email)
        ->call('updateProfile');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    $this->assertNotNull($this->user->refresh()->email_verified_at);
});

test('user can delete their account', function () {

    $this->actingAs($this->user);

    $component = Volt::test('profile.delete-user-form')
        ->set('password', 'password')
        ->call('deleteUser');

    $component
        ->assertHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($this->user->fresh());
})->skip(message: 'un usuario no debe eliminar su cuenta');

test('correct password must be provided to delete account', function () {

    $this->actingAs($this->user);

    $component = Volt::test('profile.delete-user-form')
        ->set('password', 'wrong-password')
        ->call('deleteUser');

    $component
        ->assertHasErrors('password')
        ->assertNoRedirect();

    $this->assertNotNull($this->user->fresh());
})->skip(message: 'un usuario no debe eliminar su cuenta');
