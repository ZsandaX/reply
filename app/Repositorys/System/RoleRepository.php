<?php

namespace App\Repositorys\System;

use App\Entities\System\Role;
use App\Repositorys\ResourceRepository;
class RoleRepository extends ResourceRepository
{
    protected $fields = [
        "id",
        "name",
        "guard_name"
    ];

    protected $relationships = [
        "permissions"
    ];

    public function __construct(Role $role)
    {
        parent::__construct($role);
    }
}
