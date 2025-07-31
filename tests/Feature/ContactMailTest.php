<?php

declare(strict_types=1);

use App\Livewire\Contact;
use Illuminate\Support\Facades\Mail;

use function Pest\Livewire\livewire;

uses()->group('contact');

beforeEach(function () {
    $this->user = new_user();
});

// ContactMailTest

it('check if a contact mail can be send', function () {
    set_carbon();

    Mail::fake();

    livewire(Contact::class, [1, 1])
        ->set('firstname', 'Juan')
        ->set('lastname', 'Marchant')
        ->set('email', 'mail@mail.com')
        ->set('message', 'This is a test message')
        ->set('resultado', 2)
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSessionHas('success', 'Mensaje enviado');

    Mail::assertSent(Blockpc\App\Mails\ContactEmail::class, function ($mail) {
        return $mail->data['firstname'] === 'Juan' &&
               $mail->data['lastname'] === 'Marchant' &&
               $mail->data['email'] === 'mail@mail.com' &&
               $mail->data['message'] === 'This is a test message' &&
               $mail->data['resultado'] === 2;
    });
});
