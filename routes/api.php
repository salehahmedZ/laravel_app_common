<?php

use Saleh\LaravelAppCommon\Http\Controllers\AppMsgGet;
use Saleh\LaravelAppCommon\Http\Middleware\Localization;
use Saleh\LaravelAppCommon\Http\Middleware\SilentMode;

Route::prefix('api')->middleware([
    SilentMode::class,
    Localization::class,
    'throttle:api50',
])->group(function () {
    Route::post('appMsg/get', AppMsgGet::class)->middleware('throttle:api5');
});
