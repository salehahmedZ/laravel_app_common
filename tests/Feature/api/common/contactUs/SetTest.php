<?php

use function Pest\Laravel\postJson;

$url = 'api/common/contactUs/set';

it('must Be Logged In')->mustBeAdmin($url);

test('set contactUs route', function () use ($url) {
    actingAsAdmin();

    $data = contactUs;
    $data['email'] = 'test@test.test';
    $data['whatsapp'] = '12345';

    $res = postJson($url, ['contactUs' => $data]);
    $res->assertJsonPath('msg', 'Done');
    $res->assertJsonPath('success', true);

    $res = postJson('api/common/contactUs/get');
    $res->assertJsonPath('contactUs', $data);
});
