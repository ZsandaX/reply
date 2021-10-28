<?php

namespace App\Http\Controllers\Paper;

use App\Http\Controllers\ResourceController;
use App\Repositorys\Paper\PaperRepository;

class PaperController extends ResourceController
{
    public function __construct(PaperRepository $PaperRepository)
    {
        $this->repository = $PaperRepository;
    }

    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'value' => ['required', 'integer', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'groups' => ['nullable', 'array'],
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
            "groups" => "題組",
        ];
    }

    public function properties()
    {
        $id = request()->route("user");

        return [
            "name" => ["component" => "el-input", "required" => true],
            "value" => ["component" => "el-input", "required" => true],
            "description" => ["component" => "el-input", "required" => false],
            "groups" => ["component" => "Table", "required" => false],
        ];
    }
}
