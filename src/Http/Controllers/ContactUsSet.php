<?php

namespace Saleh\LaravelAppCommon\Http\Controllers\Admin\AppMsg;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Saleh\LaravelAppCommon\Helpers\ContactUs;

class ContactUsSet extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $newData = $request->appMsg;

        $data = [
            'msg' => 'Done',
            'success' => (new ContactUs())->set($newData),
        ];

        return response()->json($data);
    }
}
