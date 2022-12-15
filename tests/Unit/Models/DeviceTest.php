<?php

use Saleh\LaravelAppCommon\Events\DeviceWasCreated;
use Saleh\LaravelAppCommon\Models\Device;

test('Device Model', function () {
    Event::fake([
        DeviceWasCreated::class,
    ]);

    $result = Device::updateOrCreateDevice([
        'deviceID' => '123',
    ]);

    expect($result->deviceID)->toBe('123');

    Event::assertDispatched(DeviceWasCreated::class, function ($event) use ($result) {
        return $event->device->id === $result->id;
    });
});

test('Device Model 1', function () {
    $result = Device::updateOrCreateDevice([
        'notificationToken' => 'token',
    ]);

    expect($result->notificationToken)->toBe('token');
});

test('Device Model 2', function () {
    $result = Device::updateOrCreateDevice([
        'deviceID' => '123',
        'notificationToken' => 'token',
    ]);

    expect($result->notificationToken)->toBe('token')->and($result->deviceID)->toBe('123');
});
test('Device Model null', function () {
    $result = Device::updateOrCreateDevice([
        'deviceID' => null,
        'notificationToken' => null,
    ]);

    expect($result)->toBeNull();
});

test('Device Model exist', closure: function () {
    $device = Device::factory()->create(['deviceID' => '123']);
    Device::factory()->create();

    $result = Device::updateOrCreateDevice([
        'deviceID' => '123',
        'notificationToken' => 'token new one',
    ]);

    expect($result->id)->not->toEqual($device->id)->and($result->notificationToken)->toBe('token new one')->and($result->deviceID)->toBe('123');
});
