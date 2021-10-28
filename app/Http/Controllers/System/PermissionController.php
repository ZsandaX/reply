<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\ResourceController;
use App\Repositorys\System\PermissionRepository;
use Illuminate\Support\Facades\Route;

class PermissionController extends ResourceController
{
    //
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->repository = $permissionRepository;
    }

    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'guard_name' => ['nullable', 'string', 'max:255'],
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            "resource" => "資源",
            "name" => "名稱",
            "guard_name" => "guard",
        ];
    }

    public function properties()
    {
        return [
            "name" => ["component" => "el-input", "required" => true],
            "guard_name" => ["component" => "el-input", "required" => false],
        ];
    }

    public function filters()
    {
        return [
            'guard_name' => [["text" => "web", "value" => "web"], ["text" => "api", "value" => "api"]],
            'resource' => $this->repository->getResource()->map(function ($item) {
                return ["text" => $item, "value" => $item];
            }),
        ];
    }

    public function sorts()
    {
        return [
            "name" => "custom",
            "guard_name" => "custom",
        ];
    }
}
