<?php

namespace App\Entities\System;

use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    //

    public $appends = ['resource'];

    public function getResourceAttribute($value)
    {
        return explode(".", $this->name)[0];
    }

    public function scopeResource($query, $filter)
    {
        $filter = implode("|", $filter);
        return $query->where("name", "RLIKE", "^($filter).*");
    }
}
