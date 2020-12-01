<?php

namespace App\Http\Controllers\Paper;

use App\Http\Controllers\ResourceController;
use App\Repositorys\Paper\OptionRepository;

class OptionController extends ResourceController
{
    public function __construct(OptionRepository $OptionRepository)
    {
        $this->repository = $OptionRepository;
    }
}
