<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    // handle request
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user()->hasRole($role)) {
            return $request->expectsJson()
                ? response()->json(['message' => 'unauthorized resource'], 403)
                : abort(403, 'You are not authorized to access this page');
        }
        return $next($request);
    }
}
