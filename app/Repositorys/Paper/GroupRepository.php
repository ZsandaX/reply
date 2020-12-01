<?php

namespace App\Repositorys\Paper;

use App\Repositorys\ResourceRepository;
use App\Entities\Paper\Group;

class GroupRepository extends ResourceRepository
{
    protected $fields = [
        "id",
        "label",
        "value",
        "created_at",
        "updated_at",
    ];
    public function __construct(Group $group)
    {
        parent::__construct($group);
        //$this->make($group);
    }
}
