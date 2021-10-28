<?php

namespace App\Repositorys\Paper;

use App\Entities\Paper\Group;
use App\Repositorys\ResourceRepository;
use App\Entities\Paper\Paper;
use Illuminate\Database\Eloquent\RelationNotFoundException;

class PaperRepository extends ResourceRepository
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
    ];

    public function __construct(Paper $paper)
    {
        parent::__construct($paper);
    }

    public function show($id)
    {
        //

        $model = $this->model->findOrFail($id);
        $fn = function ($query) {
            $query->orderBy("order");
        };

        $this->loadChildren($model, [
            "options" => $fn,
            "questions" => $fn,
            "children" => $fn,
            "groups" => $fn,
        ]);

        return $model;
    }
}
