<?php

namespace App\Repositorys\System;

use App\Repositorys\ResourceRepository;
use App\Entities\System\User;
use Illuminate\Http\Request;

class UserRepository extends ResourceRepository
{
    protected $fields = [
        "id",
        "name",
        "email",
    ];
    protected $relationships = [
        "roles",
        "permissions"
    ];

    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
