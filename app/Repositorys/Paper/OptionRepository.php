<?php

namespace App\Repositorys\Paper;

use App\Repositorys\ResourceRepository;
use App\Entities\Paper\Option;

class OptionRepository extends ResourceRepository
{
    protected $fields = [
        "id",
        "label",
        "value",
        "created_at",
        "updated_at",
    ];
    public function __construct(Option $option)
    {
        parent::__construct($option);
    }
}
