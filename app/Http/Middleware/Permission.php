<?php

namespace App\Http\Middleware;

use App\Helpers\Response;
use Closure;
use Illuminate\Support\Facades\Auth;

class Permission
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
        $infoRequest = $request->route()->getAction();

        if (in_array('permission', $infoRequest['middleware'])) {
            $controller = $infoRequest['controller'];
            if (auth()->user()->hasPermission($controller))  return $next($request);
        }
        return Response::unauthorized();
    }
}
