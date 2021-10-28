<?php

namespace App\Entities\System;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $attributes = [
        "icon" => "el-icon-star-off",
        'menu_id' => null,
        'disabled' => false,
    ];

    protected $casts = [
        'disabled' => 'boolean',
    ];

    public function children()
    {
        return $this->hasMany('App\Entities\System\Menu');
    }

    public function parent()
    {
        return $this->belongsTo('App\Entities\System\Menu');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return "path";
    }
}
