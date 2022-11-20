<?php

namespace Saleh\LaravelAppCommon\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MustBeSanctumAuthenticated
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (! Auth::guard('sanctum')->check()) {
            return response()->json([
                'msg' => trans('LaravelAppCommon::api.Sign in first'),
                'needsLogin' => true,
                'success' => false,
            ]);
        }

        return $next($request);
    }
}
