<?php

namespace App\Http\Controllers\Paper;

use App\Http\Controllers\ResourceController;
use App\Repositorys\Paper\OptionRepository;

class OptionController extends ResourceController
{
    public function __construct(OptionRepository $OptionRepository)
    {
        $this->repository = $OptionRepository;
    }

    public function rules()
    {
        $id = request("id");
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'value' => [ 'required', 'integer', 'max:255'],
            'questions' => [ 'nullable', 'array'],
        ];

        return $rules;
    }

    public function attributes()
    {
        $id = request()->route("user");

        return [
            "name" => "名稱",
            "value" => "值",
            "questions" => "題目"
        ];
    }

    public function properties()
    {
        $id = request()->route("user");

        return [
            "name" => ["component" => "el-input", "required" => true],
            "value" => ["component" => "el-input", "required" => true],
            "questions" => ["component" => "Table", "required" => false],
        ];
    }
}
