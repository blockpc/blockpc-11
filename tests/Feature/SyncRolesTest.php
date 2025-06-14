<?php

use Blockpc\App\Console\Services\RoleSynchronizerService;

uses()->group('sistema', 'roles');

// SyncRolesTest

it('todos los roles están sincronizados', function () {
    $sync = app(RoleSynchronizerService::class);

    expect($sync->getMissing())->toBeEmpty('Hay roles faltantes');
    expect($sync->getOrphans())->toBeEmpty('Hay roles huérfanos');
});
