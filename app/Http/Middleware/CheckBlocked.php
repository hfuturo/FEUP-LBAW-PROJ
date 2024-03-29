<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check())
            return $next($request);

        if (!auth()->user()->blocked && ($request->routeIs('blocked') || $request->routeIs('appeal'))) {
            return redirect()->route('news');
        }

        if (
            !$request->routeIs('blocked') && !$request->routeIs('logout') && !$request->routeIs('appeal')
            && auth()->check() && auth()->user()->blocked
        ) {
            return redirect()->route('blocked');
        }
        return $next($request);
    }
}
