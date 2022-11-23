<?php

namespace Saleh\LaravelAppCommon\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Saleh\LaravelAppCommon\Helpers\ContactUs;

class ContactUsSet extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $newData = $request->contactUs;

        $data = [
            'msg' => 'Done',
            'success' => (new ContactUs())->set($newData),
        ];

        return response()->json($data);
    }
}
