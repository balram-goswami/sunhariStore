<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetTenantFromRequest
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('tenant')) {
            session(['domain_id' => $request->get('tenant')]);
        }

        return $next($request);
    }
}
