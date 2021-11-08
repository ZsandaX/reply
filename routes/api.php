<?php

use App\Entities\Paper\Group;
use App\Entities\System\Menu;
use App\Repositorys\Paper\GroupRepository;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    try{
        foreach(Menu::whereNotNull("controller")->get() as $menu){
            Route::post($menu->path."/check", $menu->controller."@check")->name("$menu->path.check");
            Route::resource($menu->path, $menu->controller);
        }
    }catch(PDOException $exception){

    }
});
