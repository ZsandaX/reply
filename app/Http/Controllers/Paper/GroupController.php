<?php

namespace App\Http\Controllers\Paper;

use App\Http\Controllers\ResourceController;
use App\Repositorys\Paper\GroupRepository;

class GroupController extends ResourceController
{
    public function __construct(GroupRepository $GroupRepository)
    {
        $this->repository = $GroupRepository;
    }

    public function rules()
    {
        $id = request("id");
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'value' => [ 'required', 'integer', 'max:255'],
            'description' => [ 'nullable', 'string', 'max:255'],
            'children' => [ 'nullable', 'array'],
            'questions' => [ 'nullable', 'array']
        ];

        return $rules;
    }

    public function attributes()
    {
        $id = request()->route("user");

        return [
            "name" => "名稱",
            "value" => "值",
            "description" => "描述",
            "children" => "題組",
            "questions" => "題目",
        ];
    }

    public function properties()
    {
        $id = request()->route("user");

        return [
            "name" => ["component" => "el-input", "required" => true],
            "value" => ["component" => "el-input", "required" => true],
            "description" => ["component" => "el-input", "required" => false],
            "children" => ["name"=> "groups","component" => "Table", "required" => false],
            "questions" => ["component" => "Table", "required" => false],
        ];
    }
}
