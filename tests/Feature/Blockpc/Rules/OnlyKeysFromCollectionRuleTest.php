<?php

declare(strict_types=1);

use Blockpc\App\Rules\OnlyKeysFromCollectionRule;
use Illuminate\Support\Facades\Validator;

uses()->group('rules');

// OnlyKeysFromCollectionRuleTest

it('will return false if key not in collection', function () {
    $collection = collect([
        1 => 'uno',
        2 => 'dos',
        3 => 'tres',
    ]);

    $validator = Validator::make(
        [
            'keys' => 4,
        ],
        ['keys' => new OnlyKeysFromCollectionRule($collection)]
    );

    expect($validator->passes())->toBeFalse();
});

it('will return true if key in collection', function () {
    $collection = collect([
        1 => 'uno',
        2 => 'dos',
        3 => 'tres',
    ]);

    $validator = Validator::make(
        [
            'keys' => 2,
        ],
        ['keys' => new OnlyKeysFromCollectionRule($collection)]
    );

    expect($validator->passes())->toBeTrue();
});

it('will return false if key not in array', function () {
    $array = [
        1 => 'uno',
        2 => 'dos',
        3 => 'tres',
    ];

    $validator = Validator::make(
        [
            'keys' => 4,
        ],
        ['keys' => new OnlyKeysFromCollectionRule($array)]
    );

    expect($validator->passes())->toBeFalse();
});

it('will return true if key in array', function () {
    $array = [
        1 => 'uno',
        2 => 'dos',
        3 => 'tres',
    ];

    $validator = Validator::make(
        [
            'keys' => 2,
        ],
        ['keys' => new OnlyKeysFromCollectionRule($array)]
    );

    expect($validator->passes())->toBeTrue();
});
