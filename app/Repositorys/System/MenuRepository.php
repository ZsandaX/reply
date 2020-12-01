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

    ];

    public function __construct(Menu $menu)
    {
        parent::__construct($menu);
    }

    public function index(Request $request)
    {
        //
        switch($request->mode){
            case "table":
                $items = parent::index($request);
            break;

            default:
            case "tree";
                $items = $this->model->select($this->fields)->whereNull("menu_id")->orderBy("order")->get();
                $this->loadChildren($items);
            break;
        }

        return $items;
    }

    public function loadChildren($items){
        foreach($items as $item){
            $item->load(["children"=> function($query){
                $query->orderBy("order");
            }]);
            $this->loadChildren($item->children);
        }
    }

    public function store($data){
        if(!isset($data['order'])){
            $data['order'] = $this->model->count();
        }
        $model = parent::store($data);

        return $model;
    }

    public function destroy($id){
        $model = parent::destroy($id);
        Permission::where("name", $model->path)->delete();

        return $model;
    }
}
