<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\ResourceController;
use App\Repositorys\System\RoleRepository;

class RoleController extends ResourceController
{
    //
    public function __construct(RoleRepository $roleRepository)
    {
        $this->repository = $roleRepository;
    }

    public function rules()
    {
        $id = request("id");
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'guard_name' => [ 'nullable', 'string', 'max:255'],
            'permissions' => [ 'nullable', 'array']
        ];

        return $rules;
    }

    public function attributes()
    {
        $id = request()->route("user");

        return [
            "name" => "名稱",
            "guard_name" => "guard",
            "permissions" => "權限"
        ];
    }

    public function properties()
    {
        $id = request()->route("user");

        return [
            "name" => ["component" => "el-input", "required" => true],
            "guard_name" => ["component" => "el-input", "required" => false],
            "permissions" => ["component" => "Table", "required" => false]
        ];
    }

    public function filters()
    {
        return [
            'guard_name' => [["text" => "web", "value" => "web"], ["text" => "api", "value" => "api"]],
        ];
    }

}
