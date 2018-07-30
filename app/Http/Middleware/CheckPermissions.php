<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isActive = Auth::user()->isactive != 1;
        $isDelete = Auth::user()->isdelete != 0;

        if (Auth::check() && ($isActive || $isDelete)) {
            Auth::logout();
            $request->session()->flash('alert-danger', 'Your Account is not activated yet.');
            return redirect('/login')->with('erro_login', 'Your error text');
        }

        $route = \Route::currentRouteName();
        $arrayResource = $request->session()->get('resources');
        $routeExplode = explode('.', $route);
        $behavior = ['create', 'read', 'update', 'delete'];

        $canAccess = null;
        if (count($routeExplode) > 1) {
            $canAccess = $routeExplode[1] == 'index' ? 'read' : $routeExplode[1];
        } else {
            $canAccess = $routeExplode[0];
        }

        if (in_array($canAccess, $behavior)) {
            $contains = str_contains($arrayResource[$routeExplode[0]], $canAccess);
            if (!$contains) {
                abort(404);
            }
        }
        return $next($request);
    }
}
