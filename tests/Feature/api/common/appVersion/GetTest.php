<?php

use function Pest\Laravel\postJson;

test('get appVersion route', function () {
    $res = postJson('api/common/appVersion/get');
    $res->assertJsonPath('msg', '');
    $res->assertJsonPath('success', true);
    $res->assertJsonPath('appVersion', appVersion);
});
