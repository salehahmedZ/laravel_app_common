<?php

use function Pest\Laravel\postJson;

test('get contactUs route', function () {
    $res = postJson('api/common/contactUs/get');
    $res->assertJsonPath('msg', '');
    $res->assertJsonPath('success', true);
    $res->assertJsonPath('contactUs', contactUs);
});
