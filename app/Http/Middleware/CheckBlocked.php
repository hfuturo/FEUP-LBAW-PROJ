<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Middleware\Route;

class CheckBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            !$request->routeIs('blocked') && !$request->routeIs('logout')
            && auth()->check() && auth()->user()->blocked
        ) {
            return redirect()->route('blocked');
        }
        return $next($request);
    }
}
