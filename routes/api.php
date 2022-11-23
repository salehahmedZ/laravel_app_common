<?php

use Saleh\LaravelAppCommon\Http\Controllers\AppMsgGet;
use Saleh\LaravelAppCommon\Http\Controllers\AppMsgSet;
use Saleh\LaravelAppCommon\Http\Controllers\AppVersionGet;
use Saleh\LaravelAppCommon\Http\Controllers\AppVersionSet;
use Saleh\LaravelAppCommon\Http\Controllers\ContactUsGet;
use Saleh\LaravelAppCommon\Http\Controllers\ContactUsSet;
use Saleh\LaravelAppCommon\Http\Middleware\Localization;
use Saleh\LaravelAppCommon\Http\Middleware\MustBeAnAdmin;
use Saleh\LaravelAppCommon\Http\Middleware\SilentMode;

Route::prefix('api')->middleware([
    SilentMode::class,
    Localization::class,
    'throttle:api50',
])->group(function () {
    Route::post('appMsg/get', AppMsgGet::class)->middleware('throttle:api50');
    Route::post('appVersion/get', AppVersionGet::class)->middleware('throttle:api50');
    Route::post('contactUs/get', ContactUsGet::class)->middleware('throttle:api50');
    //
    Route::post('appMsg/set', AppMsgSet::class)->middleware('throttle:api50', MustBeAnAdmin::class);
    Route::post('appVersion/set', AppVersionSet::class)->middleware('throttle:api50', MustBeAnAdmin::class);
    Route::post('contactUs/set', ContactUsSet::class)->middleware('throttle:api50', MustBeAnAdmin::class);
});
