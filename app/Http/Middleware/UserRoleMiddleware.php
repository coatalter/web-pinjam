<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
        if (!Auth::check()) {
            return response()->json(['You do not have permission to access for this page']);
        }

        $allowed = collect(preg_split('/[|,]/', (string) $role))
            ->map(fn ($value) => trim($value))
            ->filter();

        if ($allowed->isEmpty()) {
            return response()->json(['You do not have permission to access for this page']);
        }

        if ($allowed->contains(Auth::user()->role?->slug)) {
            return $next($request);
        }
        return response()->json(['You do not have permission to access for this page']);
    }
}
