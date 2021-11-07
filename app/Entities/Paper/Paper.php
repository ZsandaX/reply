<?php

namespace App\Entities\Paper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Paper extends Model
{
    //
    protected $attributes = [
        'description' => '',
    ];

    public function __construct()
    {
        //$this->attributes['created_by'] = Auth::guard("api")->user()->id;
    }

    public function groups()
    {
        return $this->morphToMany('App\Entities\Paper\Group', 'model', 'model_has_groups')->withPivot('order');
    }
}
