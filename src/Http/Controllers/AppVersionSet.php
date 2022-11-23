<?php

namespace Saleh\LaravelAppCommon\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Saleh\LaravelAppCommon\Helpers\AppVersion;

class AppVersionSet extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $newData = $request->appVersion;

        $data = [
            'msg' => 'Done',
            'success' => (new AppVersion())->set($newData),
        ];

        return response()->json($data);
    }
}
