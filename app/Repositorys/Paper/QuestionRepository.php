<?php

namespace App\Repositorys\Paper;
use App\Repositorys\ResourceRepository;
use App\Entities\Paper\Question;

class QuestionRepository extends ResourceRepository
{
    protected $fields = [
        "id",
        "label",
        "value",
        "created_at",
        "updated_at",
    ];
    public function __construct(Question $question)
    {
        parent::__construct($question);
    }
}
