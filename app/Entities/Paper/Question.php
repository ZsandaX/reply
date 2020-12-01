<?php

namespace App\Entities\Paper;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $attributes = [
        'description' => '',
    ];
    public function attachmentsOfOption()
    {
        return $this->belongsToMany('App\Entities\Paper\Option');
    }
    public function attachmentsOfGroup()
    {
        return $this->belongsToMany('App\Entities\Paper\Group');
    }
}
