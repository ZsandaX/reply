<?php

namespace App\Http\Controllers;

use App\Entities\System\Menu;
use App\Entities\System\Permission;
use App\Services\LayoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LayoutService $layoutService)
    {
        $this->service = $layoutService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request, Menu $menu)
    {
        Log::info('message');
        $routes = $this->service->menu($request);

        return view("home", compact("routes"));
    }
}
