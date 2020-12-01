<?php

namespace App\Repositorys;

use App\Entities\System\Permission;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\Environment\Console;

abstract class ResourceRepository
{
    protected $model;
    protected $relationships = [];
    protected $fields = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getRelationships(){
        return $this->relationships;
    }

    public function getFields(){
        return $this->fields;
    }

    public function index(Request $request)
    {
        //
        $request->per_page = $request->per_page * 1;
        $items = $this->model->with($this->relationships)->paginate($request->per_page, $this->fields);

        return $items;
    }

    public function store($data)
    {
        //
        $model = new $this->model;
        foreach ($data as $field => $value) {
            if(in_array($field, $this->relationships)){
                continue;
            }
            $model->{$field} = $value;
        }
        $model->save();

        foreach ($data as $field => $value) {
            if(in_array($field, $this->relationships)){
                $items = array_map(function($v){
                    return $v["id"];
                }, $value);
                $model->{$field}()->sync($items);
            }
        }
        return $model;
    }

    public function show($id)
    {
        //
        $model = $this->model->findOrFail($id);
        return $model;
    }

    public function update($data, $id)
    {
        //
        $model = $this->model->findOrFail($id);
        foreach ($data as $field => $value) {
            if(in_array($field, $this->relationships)){
                $items = array_map(function($v){
                    return $v["id"];
                }, $value);
                $model->{$field}()->sync($items);
                continue;
            }
            $model->{$field} = $value;
        }
        $model->save();
        return $model;
    }

    public function destroy($id)
    {
        //
        $model = $this->model->findOrFail($id);
        $model->delete();

        return $model;
    }
}
