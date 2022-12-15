<?php

use Illuminate\Http\Request;
use Saleh\LaravelAppCommon\Http\Middleware\MustBeSanctumAuthenticated;

test('Must Be Sanctum Authenticated middleware guest', function () {
    $result = (new MustBeSanctumAuthenticated())->handle(app('request'), function (Request $request) {
        $this->assertEquals('ar', app()->getLocale());
    });

    expect($result->original)->toBe([
        'msg' => 'Login in first',
        'needsLogin' => true,
        'success' => false,
    ]);
});

test('Must Be Sanctum Authenticated middleware auth', function () {
    actingAsAdmin();

    $result = (new MustBeSanctumAuthenticated())->handle(app('request'), function (Request $request) {
        return $request;
    });

    expect($result->original)->toBe(null);
});
