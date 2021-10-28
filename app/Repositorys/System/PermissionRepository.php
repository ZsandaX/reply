<?php

namespace App\Repositorys\System;

use App\Entities\System\Permission;
use App\Repositorys\ResourceRepository;

class PermissionRepository extends ResourceRepository
{
    protected $fields = [
        "id",
        "name",
        "guard_name",
    ];

    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }

    public function fastStore($category, $functions){
        $permission = new Permission();
        $permission->name = "$category";
        $permission->guard_name = "web";
        $permission->save();
        foreach($functions as $function){
            $permission = new Permission();
            $permission->name = "$category.$function";
            $permission->guard_name = "api";
            $permission->save();
        }
    }

    public function getResource(){
        return Permission::all()->unique('resource')->pluck('resource');
    }
}
