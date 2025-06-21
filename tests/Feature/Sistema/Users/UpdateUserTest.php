<?php

declare(strict_types=1);

use App\Livewire\Users\UpdateUser;
use App\Models\Role;
use Livewire\Livewire;

uses()->group('users');

beforeEach(function () {
    $this->user = new_user();
});

// UpdateUserTest

it('I cannot access the users update if I am not authenticated', function () {
    $response = $this->get(route('users.update', ['user' => $this->user->id]));

    $response->assertStatus(302);
});

it('I cannot access the users update if I do not have permission', function () {
    $response = $this->actingAs($this->user)->get(route('users.update', ['user' => $this->user->id]));

    $response->assertStatus(403);
});

it('I can access the users update authenticated and with permission', function () {
    $this->user->givePermissionTo('user update');

    $response = $this->actingAs($this->user)->get(route('users.update', ['user' => $this->user->id]));

    $response->assertStatus(200);
});

it('checking properties on view user update', function () {
    $this->user->givePermissionTo('user update');

    $admin = new_user();

    Livewire::actingAs($this->user)
        ->test(UpdateUser::class, ['user' => $admin])
        ->assertPropertyWired('name')
        ->assertPropertyWired('email')
        ->assertPropertyWired('firstname')
        ->assertPropertyWired('lastname')
        ->assertMethodWiredToForm('save');
});

it('can edit a user if have permission', function () {
    $this->user->givePermissionTo('user update');

    $admin = new_user();

    Livewire::actingAs($this->user)
        ->test(UpdateUser::class, ['user' => $admin])
        ->set('name', 'new')
        ->set('email', 'new@mail.com')
        ->set('firstname', 'lorem')
        ->set('lastname', 'ipsum')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', [
        'id' => $admin->id,
        'name' => 'new',
        'email' => 'new@mail.com',
    ]);

    $this->assertDatabaseHas('profiles', [
        'user_id' => $admin->id,
        'firstname' => 'lorem',
        'lastname' => 'ipsum',
    ]);
});

it('can add a user a new role', function () {
    $this->user->givePermissionTo('user update');

    $admin = new_user();

    $role = Role::factory()->create([
        'name' => 'new',
        'display_name' => 'New',
    ]);

    expect($admin->hasRole('new'))->toBeFalse();

    Livewire::actingAs($this->user)
        ->test(UpdateUser::class, ['user' => $admin])
        ->call('select_role', $role->id)
        ->assertHasNoErrors();

    $admin->refresh();

    expect($admin->hasRole('new'))->toBeTrue();
});

it('can remove a user a new role', function () {
    $this->user->givePermissionTo('user update');

    $admin = new_user(role: 'admin');

    $role = Role::whereName('admin')->first();

    expect($admin->hasRole('admin'))->toBeTrue();

    Livewire::actingAs($this->user)
        ->test(UpdateUser::class, ['user' => $admin])
        ->call('remove_role', $role->id)
        ->assertHasNoErrors();

    $admin->refresh();

    expect($admin->hasRole('admin'))->toBeFalse();
});

it('check if can add to user new permission', function () {
    $this->user->givePermissionTo('user update');

    $admin = new_user(role: 'admin');

    $permission = App\Models\Permission::factory()->create([
        'name' => 'new permission',
        'display_name' => 'New Permission',
    ]);

    expect($admin->hasPermissionTo('new permission'))->toBeFalse();

    Livewire::actingAs($this->user)
        ->test(UpdateUser::class, ['user' => $admin])
        ->call('select_permission', $permission->id)
        ->assertHasNoErrors();

    $admin->refresh();

    expect($admin->hasPermissionTo('new permission'))->toBeTrue();
});

it('check if can delete to user permission', function () {
    $this->user->givePermissionTo('user update');

    $admin = new_user(role: 'admin');

    $permission = App\Models\Permission::factory()->create([
        'name' => 'new permission',
        'display_name' => 'New Permission',
    ]);

    $admin->givePermissionTo('new permission');

    expect($admin->hasPermissionTo('new permission'))->toBeTrue();

    Livewire::actingAs($this->user)
        ->test(UpdateUser::class, ['user' => $admin])
        ->call('remove_permission', $permission->id)
        ->assertHasNoErrors();

    $admin->refresh();

    expect($admin->hasPermissionTo('new permission'))->toBeFalse();
});

it('can change password to user, manually', function () {
    $this->user->givePermissionTo('user update');

    $admin = new_user(role: 'admin');

    Livewire::actingAs($this->user)
        ->test(UpdateUser::class, ['user' => $admin])
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('changePassword')
        ->assertHasNoErrors();

    $admin->refresh();

    $this->assertTrue(password_verify('new-password', $admin->password));
});

it('can change password to user, generating', function () {
    $this->user->givePermissionTo('user update');

    $admin = new_user(role: 'admin');

    Livewire::actingAs($this->user)
        ->test(UpdateUser::class, ['user' => $admin])
        ->call('generatePassword')
        ->assertHasNoErrors()
        ->assertSet('password', function ($value) {
            return mb_strlen($value) === 8; // Check if the generated password is 8 characters long
        })
        ->assertSet('password_confirmation', function ($value) {
            return mb_strlen($value) === 8; // Check if the confirmation matches the generated password
        });
});
