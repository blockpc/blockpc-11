<?php

use App\Livewire\Users\CreateUser;
use Blockpc\App\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses()->group('sistema', 'users');

beforeEach(function () {
    $this->user = new_user();
});

// CreateUserTest

it('no puedo acceder a la tabla de usuarios si no estoy autenticado', function () {
    $response = $this->actingAs($this->user)->get('/sistema/usuarios/crear');

    $response->assertStatus(403);
});

it('puedo acceder a la tabla de usuarios', function () {
    $this->user->givePermissionTo('user create');

    $response = $this->actingAs($this->user)->get('/sistema/usuarios/crear');

    $response->assertStatus(200);
});

it('users without role sudo cannot create new users sudo', function () {
    $this->user->givePermissionTo('user create');
    $this->user->assignRole('admin');

    $response = $this->actingAs($this->user)->get('/sistema/usuarios/crear');

    $role_sudo = Role::where('name', 'sudo')->first();

    $component = Livewire::test(CreateUser::class)
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
        ->call('save');

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
