<?php

namespace App\Http\Controllers\Paper;

use App\Http\Controllers\ResourceController;
use App\Repositorys\Paper\QuestionRepository;

class QuestionController extends ResourceController
{
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->repository = $questionRepository;
    }
}
