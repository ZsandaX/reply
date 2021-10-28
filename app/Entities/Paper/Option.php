<?php

namespace App\Entities\Paper;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
    public function questions()
    {
        return $this->morphedByMany('App\Entities\Paper\Question', 'model', 'model_has_options');
    }
}
