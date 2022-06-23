<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthSanctumHookMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('Authorization')) {
            config(['auth.defaults.guard' => 'sanctum']);
            Log::info("It's work!");
        }

        return $next($request);
    }
}
