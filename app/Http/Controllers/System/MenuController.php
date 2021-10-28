<?php

namespace App\Http\Controllers\System;

use App\Entities\System\Permission;
use App\Entities\System\User;
use App\Repositorys\System\MenuRepository;
use App\Http\Controllers\ResourceController;
use App\Repositorys\System\PermissionRepository;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;

class MenuController extends ResourceController
{
    public function __construct(MenuRepository $menuRepository)
    {

        $this->repository = $menuRepository;
    }

    public function index(Request $request)
    {
        //
        switch($request->mode){
            case "tree";
                $response = $this->repository->index($request);
            break;
            case "table":
            default:
                $response = parent::index($request);
            break;
        }
        return $response;
    }

    public function rules()
    {
        $id = request("id");

        $rules = [
            "path" => ["required", "string", "regex:/^\w{1,}(\/\w{1,})*$/", "unique:menus,path,$id"],
            "label" => ["required", "string"],
            "icon" => ["nullable", "string"],
            "component" => ["nullable", "string"],
            "controller" => ["nullable", "string"],
            "order" => ["nullable", "integer"],
            "menu_id" => ["nullable", "integer", "exists:menus,id"],
            "disabled" => ["boolean"],
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            "path" => "路徑",
            "label" => "名稱",
            "icon" => "圖標",
            "component" => "部件",
            "controller" => "控制器",
            "disabled" => "禁用",
        ];
    }

    public function properties()
    {
        return [
            "path" => ["component" => "el-input", "required" => true],
            "label" => ["component" => "el-input", "required" => true],
            "icon" => ["component" => "el-input", "required" => false],
            "component" => ["component" => "el-input", "required" => false],
            "controller" => ["component" => "el-input", "required" => false],
            "disabled" => ["component" => "el-switch", "required" => false],
        ];
    }
}
