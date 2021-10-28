<?php

namespace App\Services;

use App\Repositorys\System\MenuRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayoutService
{
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }
    public function menu(Request $request)
    {
        $permissions = $request->user()->getAllPermissions()->pluck('name');
        $routes = $this->menuRepository->index($request);
        $routes = $this->handle($routes, $permissions);


        return $routes;
    }

    private function handle($items, $permissions){
        return $items->map(function($item) use ($permissions){
            unset($item->controller, $item->order, $item->menu_id, $item->created_at, $item->updated_at);
            if(Auth::user()->hasRole("SuperAdmin")){
                $item->meta = [
                    "show" => true,
                    "create" => true,
                    "edit" => true,
                    "destroy" => true,
                ];
            }else{
                $item->meta = [
                    "show" => $permissions->search($item->path.".show") !== false,
                    "create" => $permissions->search($item->path.".create") !== false,
                    "edit" => $permissions->search($item->path.".edit")  !== false,
                    "destroy" => $permissions->search($item->path.".destroy")  !== false,
                ];
            }
            $item->children = $this->handle($item->children, $permissions);

            return $item;
        });
    }
}
