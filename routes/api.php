<?php

use App\Entities\Paper\Group;
use App\Entities\System\Menu;
use App\Repositorys\Paper\GroupRepository;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    foreach(Menu::whereNotNull("controller")->get() as $menu){
        //$roles = $menu->roles->pluck("name")->join("|");
        Route::post($menu->path."/check", $menu->controller."@check")->name("$menu->path.check");
        Route::resource($menu->path, $menu->controller);
    }
    Route::get("permission/massCreate", "System\MassPermissionController@massCreate")->name("permission.massCreate");
});
