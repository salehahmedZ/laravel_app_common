<?php

namespace Saleh\LaravelAppCommon\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

//middleware to empty msg value when silent mode is on
class SilentMode
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->input('silent') === true) {
            if ($response instanceof JsonResponse) {
                $currentData = $response->getData();

                $currentData->msg = '';

                $response->setData($currentData);
            }
        }

        return $response;
    }
}
