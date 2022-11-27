<?php

namespace Saleh\LaravelAppCommon\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Saleh\LaravelAppCommon\Helpers\AppMsg;
use Saleh\LaravelAppCommon\Helpers\AppVersion;
use Saleh\LaravelAppCommon\Helpers\ContactUs;

class GetAll extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
                'msg' => '',
                'success' => true,
                //
                'appMsg' => (new AppMsg())->get(),
                'appVersion' => (new AppVersion())->get(),
                'contactUs' => (new ContactUs())->get(),
            ]
        );
    }
}
