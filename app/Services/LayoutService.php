<?php

namespace App\Services;

use App\Repositorys\System\MenuRepository;
use Illuminate\Http\Request;

class LayoutService
{
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }
    public function menu(Request $request)
    {
        $routes = $this->menuRepository->index($request);

        return $routes;
    }
}
