<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response; // Import Response class

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            // If it's an API request, return JSON response with 403 Forbidden
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. You do not have the required role.'], Response::HTTP_FORBIDDEN);
            }

            // Otherwise, for web requests, redirect to home
            return redirect('/home');
        }

        return $next($request);
    }
}
