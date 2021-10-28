<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ResourceController extends Controller
{
    protected $repository;

    public function index(Request $request)
    {
        //
        $response = $this->repository->index($request)->toArray();

        $response["columns"] = Arr::where($this->attributes(), function ($attr, $prop) {
            return in_array($prop, $this->repository->getFields());
        });
        $response["filters"] = $this->filters();
        $response["sorts"] = $this->sorts();

        return $response;
    }


    public function __call($method, $parameters)
    {
        switch ($method) {
            case "create":
            case "edit":
                $response = [];
                $attributes = $this->attributes();
                foreach($this->properties() as $prop => $value){
                    $response[$prop] = array_merge(["label" => $attributes[$prop]], $value);
                }
                return $response;
                break;
        }
    }

    public function store()
    {
        //
        $validator = $this->validator();
        if($validator->fails()){
            return ["success"=> false, "errors" => $validator->errors()];
        }
        $data = $validator->validated();
        $data = $this->factory($data);

        $this->repository->store($data);

        return ["success" => true];
    }

    public function show($id)
    {
        //
        return $this->repository->show($id);
    }

    public function update($id)
    {
        //
        $validator = $this->validator();
        if($validator->fails()){
            return ["success"=> false, "errors" => $validator->errors()];
        }
        $data = $validator->validated();
        $data = $this->factory($data);

        $this->repository->update($data, $id);

        return ["success" => true];
    }

    public function destroy($id)
    {
        //
        return $this->repository->destroy($id);
    }

    public function check()
    {
        $validator = $this->validator();
        if($validator->fails()){
            return ["success"=> false, "errors" => $validator->errors()];
        }

        return ["success" => true];
    }

    public function validator()
    {
        $rules = $this->rules();

        $messages = $this->messages();

        $attributes = $this->attributes();

        if(explode("@", Route::currentRouteAction())[1] != "store"){
            $rules = collect($rules)->map(function($rule){
                if(is_array($rule)){
                    $rule[] = "sometimes";
                }else{
                    $rule = "sometimes|".$rule;
                }
                return $rule;
            })->toArray();
        }

        $validator = Validator::make(request()->all(), $rules, $messages, $attributes);

        return $validator;
    }

    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }

    public function filters(){
        return [];
    }

    public function sorts(){
        return [];
    }

    public function factory($data){
        return $data;
    }
}
