<?php

use Saleh\LaravelAppCommon\Helpers\LocationDataFromIP;

test('location from provided ip', function () {
    $location = new LocationDataFromIP('2605:ad80:c:34c6:b082:c2d1:3e97:b71a');

    expect($location->getIp())
        ->toBe('2605:ad80:c:34c6:b082:c2d1:3e97:b71a')
        ->and($location->getLat())
        ->toBe(33.2)
        ->and($location->getLng())
        ->toBe(-87.56)
        ->and($location->getCountry())
        ->toBe('United States')
        ->and($location->getCountryCode())
        ->toBe('US')
        ->and($location->getCity())
        ->toBe('Tuscaloosa');
});

test('location from request ip', function () {
    Request::spy();
    Request::shouldReceive('ip')->andReturn('193.62.157.66');

    $location = new LocationDataFromIP();

    expect($location->getIp())
        ->toBe('193.62.157.66')
        ->and($location->getLat())
        ->toBe(51.5074)
        ->and($location->getLng())
        ->toBe(-0.127758)
        ->and($location->getCountry())
        ->toBe('United Kingdom')
        ->and($location->getCountryCode())
        ->toBe('GB')
        ->and($location->getCity())
        ->toBe('London');
});

test('location from server with valid ip', function () {
    Request::spy();
    Request::shouldReceive('ip')->andReturn('2605:ad80:c:34c6:b082:c2d1:3e97:b71a');

    $_SERVER['HTTP_CLIENT_IP'] = '193.62.157.66';

    $location = new LocationDataFromIP();

    expect($location->getIp())
        ->toBe('193.62.157.66')
        ->and($location->getLat())
        ->toBe(51.5074)
        ->and($location->getLng())
        ->toBe(-0.127758)
        ->and($location->getCountry())
        ->toBe('United Kingdom')
        ->and($location->getCountryCode())
        ->toBe('GB')
        ->and($location->getCity())
        ->toBe('London');
});

test('location from server with invalid ip', function () {
    Request::spy();
    Request::shouldReceive('ip')->andReturn('193.62.157.66');

    $_SERVER['HTTP_CLIENT_IP'] = '123125321351235';

    $location = new LocationDataFromIP();

    expect($location->getIp())
        ->toBe('193.62.157.66')
        ->and($location->getLat())
        ->toBe(51.5074)
        ->and($location->getLng())
        ->toBe(-0.127758)
        ->and($location->getCountry())
        ->toBe('United Kingdom')
        ->and($location->getCountryCode())
        ->toBe('GB')
        ->and($location->getCity())
        ->toBe('London');
});
