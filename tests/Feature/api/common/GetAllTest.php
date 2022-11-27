<?php

use function Pest\Laravel\postJson;

test('get all route', function () {
    $res = postJson('api/common/getAll');
    $res->assertJsonPath('msg', '');
    $res->assertJsonPath('success', true);
    $res->assertJsonPath('appMsg', appMsg);
    $res->assertJsonPath('appVersion', appVersion);
    $res->assertJsonPath('contactUs', contactUs);
});
