<?php

namespace App\Entities\Paper;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $attributes = [
        'description' => "",
    ];

    public function options()
    {
        return $this->morphToMany('App\Entities\Paper\Option', 'model', 'model_has_options');
    }
    public function groups()
    {
        return $this->morphedByMany('App\Entities\Paper\Group', 'model', 'model_has_questions');
    }
}
