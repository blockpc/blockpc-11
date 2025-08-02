<?php

declare(strict_types=1);

namespace Tests\Helpers;

use Blockpc\App\Traits\AuthorizesRoleOrPermissionTrait;

final class DummyAuthorizer
{
    use AuthorizesRoleOrPermissionTrait;
}
