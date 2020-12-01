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
}
