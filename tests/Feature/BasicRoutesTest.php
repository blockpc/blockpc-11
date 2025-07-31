<?php

declare(strict_types=1);

uses()->group('routes');

beforeEach(function () {
    $this->user = new_user();
});

// BasicRoutesTest

it('check if get a home', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
    $response->assertSeeLivewire('home');
});

it('check if get a contact', function () {
    $response = $this->get(route('contact'));

    $response->assertStatus(200);
    $response->assertSeeLivewire('contact');
});
