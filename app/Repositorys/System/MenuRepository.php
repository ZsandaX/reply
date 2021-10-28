<?php

namespace App\Repositorys\System;

use App\Repositorys\ResourceRepository;
use App\Entities\System\Menu;
use App\Entities\System\Permission;
use Illuminate\Http\Request;

class MenuRepository extends ResourceRepository
{
    protected $fields = [
        "id",
        "path",
        "label",
        "icon",
        "component",
        "controller",
        "order",
        "menu_id",
        "disabled",
    ];

    protected $relationships = [
        "children"
    ];

    public function __construct(Menu $menu)
    {
        parent::__construct($menu);
    }

    public function index(Request $request)
    {
        //
        $load = ["children" => function ($query) {
            $query->orderBy("order");
        }];

        switch ($request->mode) {
            case "table":
                $items = $this->model->select($this->fields)->whereNull("menu_id")->orderBy("order")->paginate();
                foreach($items->items() as $item){
                    $this->loadChildren($item, $load);
                }
                break;

            default:
            case "tree";
                $items = $this->model->select($this->fields)->whereNull("menu_id")->orderBy("order")->get();
                foreach($items as $item){
                    $this->loadChildren($item, $load);
                }
                break;
        }

        return $items;
    }

    public function store($data)
    {
        if (!isset($data['order'])) {
            $data['order'] = $this->model->count();
        }
        $model = parent::store($data);

        return $model;
    }
}
