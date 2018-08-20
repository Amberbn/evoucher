<?php

namespace App\Http\Middleware;

use App\Client;
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
        $user = Auth::user();
        $isActive = $user->isactive != 1;
        $isDelete = $user->isdelete != 0;

        $client = Client::where('client_id', $user->client_id)->first();

        if (!$client) {
            return $this->forceLogout();
        }

        if (Auth::check() && ($isActive || $isDelete)) {
            return $this->forceLogout();
        }

        $clientIsactive = $client->isactive != 1;
        $clientIsDelete = $client->isdelete != 0;

        if (($clientIsactive || $clientIsDelete)) {
            return $this->forceLogout();
        }

        $route = \Route::currentRouteName();
        $arrayResource = $request->session()->get('resources');
        $routeExplode = explode('.', $route);
        $routeDefine = ['create', 'read', 'update', 'delete'];

        if (count($routeExplode) > 2) {
            if ($routeExplode[2] == 'custom') {
                return $next($request);
            }
        }

        $canAccess = null;
        if (count($routeExplode) > 1) {
            $canAccess = $routeExplode[1] == 'index' ? 'read' : $routeExplode[1];
        } else {
            $canAccess = $routeExplode[0];
        }

        if (in_array($canAccess, $routeDefine)) {
            $contains = null;
            if (isset($arrayResource[$routeExplode[0]])) {
                $contains = str_contains($arrayResource[$routeExplode[0]], $canAccess);
            }
            if (!$contains) {
                abort(404);
            }
        }
        return $next($request);
    }

    public function forceLogout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message', 'These credentials do not match our records.');
    }
}
