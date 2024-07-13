<?php

use App\Models\Profile;
use App\Models\User;

uses()->group('helpers');

// HelperNewUserTest

test('profile belongs to a user', function () {
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);

    $this->assertInstanceOf(User::class, $profile->user);
});

test('creating profile updates user name', function () {
    $user = User::factory()->create();
    $profileData = [
        'firstname' => 'John',
        'lastname' => 'Doe',
        'user_id' => $user->id,
    ];

    Profile::create($profileData);

    $user->refresh();

    $this->assertSame('John Doe', $user->fullname);
});

test('updating profile updates user name', function () {
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);

    $profile->update([
        'firstname' => 'Jane',
        'lastname' => 'Doe',
    ]);

    $user->refresh();

    $this->assertSame('Jane Doe', $user->fullname);
});

test('profile fillable attributes', function () {
    $fillable = ['firstname', 'lastname', 'image', 'user_id'];

    $profile = new Profile();

    foreach ($fillable as $attribute) {
        $this->assertContains($attribute, $profile->getFillable());
    }
});

test('profile timestamps are disabled', function () {
    $profile = new Profile();

    $this->assertFalse($profile->timestamps);
});

it('check if new user is created with new_user', function ()
{
    $user = new_user(user: [
        'name' => 'xxx',
        'email' => 'jhondoe@mail.com',
    ], profile: [
        'firstname' => 'John',
        'lastname' => 'Doe',
    ], role: 'admin');

    expect($user->name)->toBe('xxx');
    expect($user->fullname)->toBe('John Doe');
    expect($user->email)->toBe('jhondoe@mail.com');
    expect($user->profile->firstname)->toBe('John');
    expect($user->profile->lastname)->toBe('Doe');
    expect($user->hasRole('admin'))->toBeTrue();
});
