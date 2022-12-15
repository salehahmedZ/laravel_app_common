<?php

use Illuminate\Http\Request;
use Saleh\LaravelAppCommon\Http\Middleware\Localization;
use Symfony\Component\HttpFoundation\HeaderBag;

test('localization supported locale', function () {
    app()->bind('request', function () {
        $new = new Illuminate\Http\Request();
        $new->headers = new HeaderBag([
            'x-localization' => 'en',
        ]);

        return $new;
    });

    (new Localization())->handle(app('request'), function (Request $request) {
        $this->assertEquals('en', app()->getLocale());
    });
});

test('localization unsupported locale', function () {
    app()->bind('request', function () {
        $new = new Illuminate\Http\Request();
        $new->headers = new HeaderBag([
            'x-localization' => 'tr',
        ]);

        return $new;
    });

    (new Localization())->handle(app('request'), function (Request $request) {
        $this->assertEquals('ar', app()->getLocale());
    });
});

test('localization get user locale', function () {
    $admin = actingAsAdmin();
    $admin->appLang = 'ar';

    app()->bind('request', function () use ($admin) {
        $new = new Illuminate\Http\Request();
        $new->headers = new HeaderBag([
            'x-localization' => 'en',
        ]);
        $new->user = $admin;

        return $new;
    });

    (new Localization())->handle(app('request'), function (Request $request) {
        $this->assertEquals('ar', app()->getLocale());
    });
});
