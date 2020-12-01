<?php

namespace App\Entities\Paper;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
    public function attachmentsOfQuestion()
    {
        return $this->belongsToMany('App\Entities\Paper\Question');
    }
}
