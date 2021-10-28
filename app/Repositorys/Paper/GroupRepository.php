<?php

namespace App\Repositorys\Paper;

use App\Repositorys\ResourceRepository;
use App\Entities\Paper\Group;
use Illuminate\Http\Request;

class GroupRepository extends ResourceRepository
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
        "parent",
        "children",
        "questions",
    ];

    public function __construct(Group $group)
    {
        parent::__construct($group);
    }

    public function index(Request $request)
    {
        //
        $request->per_page = $request->per_page * 1;
        $request->filters = json_decode($request->filters) ?? [];
        $items = $this->model->select($this->fields)->doesnthave("parent")
            ->where(function ($query) use ($request) {
                foreach ($this->fields as $field) {
                    $query->orWhere($field, 'like', "%" . $request->keyword . "%");
                }
            })
            ->where(function ($query) use ($request) {
                foreach ($request->filters as $prop => $filter) {
                    if (in_array($prop, $this->fields)) {
                        $query->whereIn($prop, $filter);
                    } else {
                        $query->{$prop}($filter);
                    }
                }
            });
        if ($request->sorts && in_array($request->sorts[0], $this->fields)) {
            $items = $items->orderBy($request->sorts[0], $request->sorts[1]);
        }
        $items = $items->paginate($request->per_page, $this->fields);
        $fn = function ($query) {
            $query->orderBy("order");
        };

        foreach($items->items() as $item){
            $this->loadChildren($item, ["children" => $fn, "questions" => $fn]);
        }

        return $items;
    }
}
