<?php

declare(strict_types=1);

use Blockpc\App\Rules\AreEqualsRule;
use Illuminate\Support\Facades\Validator;

uses()->group('rules');

beforeEach(function () {
    $this->user = new_user();
});

// AreEqualsRuleTest

it('will return true if the string are equals', function () {

    $validator = Validator::make(
        ['username' => 'lorem ipsum'],
        ['username' => new AreEqualsRule('lorem ipsum')]
    );

    expect($validator->passes())->toBe(true);
});

it('will return false if the string are not equals', function () {

    $validator = Validator::make(
        ['username' => 'other thing'],
        ['username' => new AreEqualsRule('lorem ipsum')]
    );

    expect($validator->passes())->toBe(false);
});
