<?php

namespace Saleh\LaravelAppCommon\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MustBeAnAdmin
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = auth('sanctum')->user();

        if (is_null($user) || $user->isAdmin === false) {
            return response()->json([
                'msg' => trans('LaravelAppCommon::api.You are not an admin'),
                'success' => false,
            ]);
        }

        return $next($request);
    }
}
