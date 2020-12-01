<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResourceController;
use App\Repositorys\System\RoleRepository;
use App\Repositorys\System\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends ResourceController
{
    //
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function rules()
    {
        $id = request("id");

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => [($id ? 'nullable' : 'required'), 'string', 'min:8', 'confirmed'],
            'roles' => ['nullable', 'array'],
            'permissions' => ['nullable', 'array']
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            "name" => "名稱",
            "email" => "email",
            "password" => "密碼",
            "password_confirmation" => "重複密碼",
            "roles" => "角色",
            "permissions" => "權限"
        ];
    }

    public function properties()
    {
        $id = request()->route("user");

        return [
            "name" => ["component" => "el-input", "required" => true],
            "email" => ["component" => "el-input", "required" => true],
            "password" => ["component" => "el-input", "required" => is_null($id), "show-password" => true],
            "password_confirmation" => ["component"  => "el-input", "required" => is_null($id), "show-password" => true],
            "roles" => ["component" => "Table", "required" => false,],
            "permissions" => ["component" => "Table", "required" => false,]
        ];
    }
}
