<?php

use Saleh\LaravelAppCommon\Helpers\RequestData;
use Saleh\LaravelAppCommon\Models\Device;
use function Spatie\Snapshots\assertMatchesJsonSnapshot;
use Symfony\Component\HttpFoundation\ServerBag;

test('Request device Data', closure: function () {
    $admin = actingAsAdmin();

    Request::spy();
    Request::shouldReceive('ip')->andReturn('193.62.157.66');
    Request::shouldReceive('user')->andReturn($admin);

    $requestData = RequestData::instance();
    expect($requestData->user())->toBe($admin)
    ->and($requestData->user()->timestamps)->toBe(true)->and($requestData->device())->toBeNull();

    assertMatchesJsonSnapshot(json_encode($requestData->deviceData()));
    assertMatchesJsonSnapshot(json_encode($requestData->metaData()));
});

test('Request deviceData when X-Impersonation', closure: function () {
    $admin = actingAsAdmin();

    Request::spy();
    Request::shouldReceive('ip')->andReturn('193.62.157.66');
    Request::shouldReceive('user')->andReturn($admin);
    Request::shouldReceive('header')->with('X-Impersonation', false)->andReturn(true);

    $requestData = RequestData::instance();
    expect($requestData->device())->toBeNull()
    ->and($requestData->deviceData())->toBe([])
    ->and($requestData->metaData())->toBe([])
    ->and($requestData->user())->toBe($admin)
    ->and($requestData->user()->timestamps)->toBe(false);
});

test('Request deviceData set new instance', closure: function () {
    $new = new Illuminate\Http\Request();
    $new->deviceOS = 'ios';
    $new->deviceModel = 'iphone12.1';
    $new->notificationToken = 'notification Token';
    $new->deviceOSVersion = 'deviceOSVersion';
    $new->deviceID = 'deviceID_123';
    $new->appBuild = '123.1';
    $new->appLang = 'ar';
    $new->appThemeMode = 'system';
    $new->newProp = 'new prop';

    $requestData = RequestData::instance($new);

    expect($requestData->newProp)->toBe('new prop');
});

test('Request deviceData get device by deviceID', closure: function () {
    app()->bind('request', function () {
        $new = new Illuminate\Http\Request();
        $new->deviceOS = 'ios';
        $new->deviceModel = 'iphone12.1';
        $new->notificationToken = 'notification Token';
        $new->deviceOSVersion = 'deviceOSVersion';
        $new->deviceID = 'deviceID_123';
        $new->appBuild = '123.1';
        $new->appLang = 'ar';
        $new->appThemeMode = 'system';
        $new->newProp = 'new prop';

        $new->server = new ServerBag([
            'REMOTE_ADDR' => '193.62.157.66',
        ]);

        return $new;
    });

    $requestData = RequestData::instance();

    $device = Device::factory()->create(['deviceID' => 'deviceID_123']);

    expect($requestData->device()->id)->toEqual($device->id);
    assertMatchesJsonSnapshot(json_encode($requestData->deviceData()));
    assertMatchesJsonSnapshot(json_encode($requestData->metaData()));
});

test('Request deviceData get device by notification Token', closure: function () {
    app()->bind('request', function () {
        $new = new Illuminate\Http\Request();
        $new->deviceOS = 'ios';
        $new->deviceModel = 'iphone12.1';
        $new->notificationToken = 'notification_token';
        $new->deviceOSVersion = 'deviceOSVersion';
        $new->appBuild = '123.1';
        $new->appLang = 'ar';
        $new->appThemeMode = 'system';
        $new->newProp = 'new prop';

        $new->server = new ServerBag([
            'REMOTE_ADDR' => '193.62.157.66',
        ]);

        return $new;
    });

    $requestData = RequestData::instance();

    $device = Device::factory()->create(['notificationToken' => 'notification_token']);

    expect($requestData->device()->id)->toEqual($device->id);
    assertMatchesJsonSnapshot(json_encode($requestData->deviceData()));
    assertMatchesJsonSnapshot(json_encode($requestData->metaData()));
});
