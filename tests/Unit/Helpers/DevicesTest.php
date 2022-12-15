<?php

use Saleh\LaravelAppCommon\Helpers\Devices;

test('get device name', function () {
    //normal
    $deviceName = Devices::getDeviceName('iPhone12,1');
    expect($deviceName)->toBe('iPhone 11');

    //case insensitive
    $deviceName = Devices::getDeviceName('iphone12,1');
    expect($deviceName)->toBe('iPhone 11');

    //trim spaces
    $deviceName = Devices::getDeviceName(' iphone12,1 ');
    expect($deviceName)->toBe('iPhone 11');

    //null
    $deviceName = Devices::getDeviceName(null);
    expect($deviceName)->toBe(null);

    //not found
    $deviceName = Devices::getDeviceName('new phone');
    expect($deviceName)->toBe('new phone');
});
