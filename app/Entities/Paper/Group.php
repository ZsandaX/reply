<?php

namespace App\Entities\Paper;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $attributes = [
        'description' => '',
    ];

    public function attachmentsOfQuestion()
    {
        return $this->belongsToMany('App\Entities\Paper\Question');
    }
}
