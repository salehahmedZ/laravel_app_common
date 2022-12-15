<?php

use Saleh\LaravelAppCommon\LaravelAppCommon;

test('Facade', function () {
    $result = LaravelAppCommon::user();
    expect($result)->toBe('Saleh\LaravelAppAuth\Models\User');
});
