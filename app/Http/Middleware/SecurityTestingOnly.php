<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityTestingOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('security_testing.enabled') !== true) {
            abort(404);
        }

        return $next($request);
    }
}
