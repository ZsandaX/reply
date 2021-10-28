<?php

namespace App\Entities\Paper;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $attributes = [
        'description' => ' ',
    ];

    protected $hidden = ['pivot'];

    public function questions()
    {
        return $this->morphToMany('App\Entities\Paper\Question', 'model', 'model_has_questions');
    }

    public function parent()
    {
        return $this->morphedByMany('App\Entities\Paper\Group', 'model', 'model_has_groups');
    }

    public function children()
    {
        return $this->morphToMany('App\Entities\Paper\Group', 'model', 'model_has_groups');
    }
}
