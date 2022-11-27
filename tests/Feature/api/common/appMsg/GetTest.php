<?php

use function Pest\Laravel\postJson;

test('get appMsg route', function () {
    $res = postJson('api/common/appMsg/get');
    $res->assertJsonPath('msg', '');
    $res->assertJsonPath('success', true);
    $res->assertJsonPath('appMsg', appMsg);
});
