<?php

declare(strict_types=1);

use App\Livewire\Profile;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = new_user();
});

// ProfileTest

test('profile page is displayed', function () {
    $this->actingAs($this->user);

    $response = $this->get('/perfil-usuario');

    $response->assertOk();
});

it('profile page contains properties and methods', function () {
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

    $this->assertSame('Test User', $this->user->fullname);
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

    $component = Livewire::test(Profile::class)
        ->set('delete_email', $this->user->email)
        ->set('delete_current_password', 'password')
        ->call('deleteAccount');

    $component
        ->assertHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($this->user->fresh());
});

test('correct password must be provided to delete account', function () {

    $this->actingAs($this->user);

    $component = Livewire::test(Profile::class)
        ->set('delete_email', $this->user->email)
        ->set('delete_current_password', 'wrong-password')
        ->call('deleteAccount');

    $component
        ->assertHasErrors('delete_current_password')
        ->assertNoRedirect();

    $this->assertNotNull($this->user->fresh());
});
