<?php

use App\Livewire\Users\CreateUser;
use App\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses()->group('sistema', 'users');

beforeEach(function () {
    $this->user = new_user();
});

// CreateUserTest

it('checking properties on view', function () {
    $this->user->givePermissionTo('user create');

    Livewire::actingAs($this->user)
        ->test(CreateUser::class)
        ->assertPropertyWired('name')
        ->assertPropertyWired('email')
        ->assertPropertyWired('firstname')
        ->assertPropertyWired('lastname')
        ->assertPropertyWired('role_id')
        ->assertMethodWiredToForm('save');
});

it('can not create a new user if dont have permission', function () {
    Livewire::actingAs($this->user)
        ->test(CreateUser::class)
        ->set('name', 'new')
        ->set('email', 'new@mail.com')
        ->set('firstname', 'lorem')
        ->set('lastname', 'ipsum')
        ->call('save')
        ->assertForbidden();
});

it('can create a new user if have permission', function () {
    $this->user->givePermissionTo('user create');

    $admin = Role::where('name', 'admin')->first();

    Livewire::actingAs($this->user)
        ->test(CreateUser::class)
        ->set('name', 'new')
        ->set('email', 'new@mail.com')
        ->set('firstname', 'lorem')
        ->set('lastname', 'ipsum')
        ->set('role_id', $admin->id)
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', [
        'email' => 'new@mail.com',
    ]);
});

it('users without role sudo cannot create new users sudo', function () {
    $this->user->assignRole('admin');

    $role_sudo = Role::where('name', 'sudo')->first();

    Livewire::actingAs($this->user)
        ->test(CreateUser::class)
        ->set('name', 'name')
        ->set('firstname', 'Nombre')
        ->set('lastname', 'Apellido')
        ->set('email', 'mail@mail.com')
        ->set('role_id', $role_sudo->id)
        ->call('save')
        ->assertHasErrors(['role_id']);
});

it('checks if photo exists in storage', function () {
    $this->user->givePermissionTo('user create');
    $this->actingAs($this->user);

    // Falsa foto para la prueba
    Storage::fake('public');

    // Supongamos que la propiedad photo es un UploadedFile
    $fakePhoto = UploadedFile::fake()->image('photo.jpg');

    // Crea una instancia del componente Livewire
    $component = Livewire::test(CreateUser::class)
        ->set('photo', $fakePhoto);

    // Llama al método que guarda la foto
    $component->call('savePhoto');

    // Verifica que la foto existe en el storage
    $path = 'photos/'.$fakePhoto->hashName();
    Storage::disk('public')->assertExists($path);
});

it('check if user is created', function () {
    $this->user->givePermissionTo('user create');
    $this->actingAs($this->user);

    // Falsa foto para la prueba
    Storage::fake('public');

    // Supongamos que la propiedad photo es un UploadedFile
    $fakePhoto = UploadedFile::fake()->image('photo.jpg');

    // busca el role admin
    $role_admin = Role::where('name', 'admin')->first();

    // Crea una instancia del componente Livewire
    $component = Livewire::test(CreateUser::class)
        ->set('photo', $fakePhoto)
        ->set('name', 'name')
        ->set('firstname', 'Nombre')
        ->set('lastname', 'Apellido')
        ->set('email', 'mail@mail.com')
        ->set('role_id', $role_admin->id)
        ->call('save')
        ->assertHasNoErrors();

    // Verifica que el usuario fue creado
    $this->assertDatabaseHas('users', [
        'email' => 'mail@mail.com',
        'name' => 'name',
    ]);

    // Verifica que el perfil del usuario fue creado
    $this->assertDatabaseHas('profiles', [
        'firstname' => 'Nombre',
        'lastname' => 'Apellido',
        'image' => 'photos/'.$fakePhoto->hashName(),
    ]);
});
