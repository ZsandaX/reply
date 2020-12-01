<?php

namespace App\Http\Middleware;

use App\Entities\System\Permission;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        if (Auth::user()->hasRole("SuperAdmin") || Auth::user()->hasPermissionTo(Route::currentRouteName(), "api")) {
            return $next($request);
        }

        throw UnauthorizedException::forPermissions([Route::currentRouteName()]);
    }
}
