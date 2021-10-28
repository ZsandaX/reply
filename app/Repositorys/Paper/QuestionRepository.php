<?php

namespace App\Repositorys\Paper;
use App\Repositorys\ResourceRepository;
use App\Entities\Paper\Question;

class QuestionRepository extends ResourceRepository
{
    protected $fields = [
        "id",
        "name",
        "value",
        "description",
        "created_at",
        "updated_at",
    ];

    protected $relationships = [
        "groups",
        "options"
    ];

    public function __construct(Question $question)
    {
        parent::__construct($question);
    }
}
