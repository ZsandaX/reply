<?php

namespace App\Http\Controllers\Paper;

use App\Http\Controllers\ResourceController;
use App\Repositorys\Paper\GroupRepository;

class GroupController extends ResourceController
{
    public function __construct(GroupRepository $GroupRepository)
    {
        $this->repository = $GroupRepository;
    }
}
