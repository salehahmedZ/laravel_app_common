<?php

namespace Saleh\LaravelAppCommon\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Saleh\LaravelAppCommon\Helpers\ContactUs;

class ContactUsGet extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
            'msg' => '',
            'success' => true,
            'contactUs' => (new ContactUs())->get(),
        ]
        );
    }
}
