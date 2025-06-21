<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Livewire\Profile;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = new_user();
});

test('password can be updated', function () {

    $this->actingAs($this->user);

    $component = Livewire::test(Profile::class)
        ->set('current_password', 'password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    $this->assertTrue(Hash::check('new-password', $this->user->refresh()->password));
});

test('correct password must be provided to update password', function () {

    $this->actingAs($this->user);

    $component = Livewire::test(Profile::class)
        ->set('current_password', 'wrong-password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword');

    $component
        ->assertHasErrors(['current_password'])
        ->assertNoRedirect();
});
