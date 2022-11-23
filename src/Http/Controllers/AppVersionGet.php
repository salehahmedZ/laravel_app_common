<?php

namespace Saleh\LaravelAppCommon\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Saleh\LaravelAppCommon\Helpers\AppVersion;

class AppVersionGet extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
            'msg' => '',
            'success' => true,
            'appVersion' => (new AppVersion())->get(),
        ]
        );
    }
}
