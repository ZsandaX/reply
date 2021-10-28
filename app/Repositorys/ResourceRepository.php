<?php

namespace App\Repositorys;

use App\Entities\System\Permission;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function getRelationships()
    {
        return $this->relationships;
    }

    public function getFields()
    {
        return array_merge($this->fields, $this->model->appends ?? []);
    }

    public function index(Request $request)
    {
        //
        $request->per_page = $request->per_page * 1;
        $request->filters = json_decode($request->filters) ?? [];
        $items = $this->model->with($this->relationships)
            ->where(function ($query) use ($request) {
                foreach ($this->fields as $field) {
                    $query->orWhere($field, 'like', "%" . $request->keyword . "%");
                }
            })
            ->where(function ($query) use ($request) {
                foreach ($request->filters as $prop => $filter) {
                    if (in_array($prop, $this->fields)) {
                        $query->whereIn($prop, $filter);
                    } else {
                        $query->{$prop}($filter);
                    }
                }
            });
        if ($request->sorts && in_array($request->sorts[0], $this->fields)) {
            $items = $items->orderBy($request->sorts[0], $request->sorts[1]);
        }
        $items = $items->paginate($request->per_page, $this->fields);

        return $items;
    }

    public function store($data)
    {
        //
        $model = new $this->model;
        foreach ($data as $field => $value) {
            if (in_array($field, $this->relationships)) {
                continue;
            }
            $model->{$field} = $value;
        }
        $model->save();

        foreach ($data as $field => $value) {
            if (in_array($field, $this->relationships)) {
                $items = array_map(function ($v) {
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
            if (in_array($field, $this->relationships)) {
                $items = array_map(function ($v) {
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

    public function loadChildren($model, $load, $sum=null)
    {
        if(is_null($sum)){
            $sum=collect();
        }
        $is_contains = $sum->contains(function($item) use ($model){
            return $item->is($model);
        });
        if($is_contains){
            return $sum;
        }
        $sum->push($model);
        foreach ($load as $key => $value) {
            if (gettype($value) == "string") {
                if (in_array($value, get_class_methods($model))) {
                    $model->load([$value]);
                    foreach($model->{$value} as $item){
                        $this->loadChildren($item, $load, $sum);
                    }
                }
            } else {
                if (in_array($key, get_class_methods($model))) {
                    $model->load([$key => $value]);
                    foreach($model->{$key} as $item){
                        $this->loadChildren($item, $load, $sum);
                    }
                }
            }
        }

        return $sum;
    }

}
