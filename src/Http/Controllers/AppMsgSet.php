<?php

namespace Saleh\LaravelAppCommon\Http\Controllers\Admin\AppMsg;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Saleh\LaravelAppCommon\Helpers\AppMsg;

class AppMsgSet extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $newData = $request->appMsg;

        $data = [
            'msg' => 'Done',
            'success' => (new AppMsg())->set($newData),
        ];

        return response()->json($data);
    }
}
