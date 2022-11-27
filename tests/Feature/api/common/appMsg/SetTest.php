<?php

use function Pest\Laravel\postJson;

$url = 'api/common/appMsg/set';

it('must Be Logged In')->mustBeAdmin($url);

test('set appMsg route', function () use ($url) {
    actingAsAdmin();

    $data = appMsg;
    $data['text']['ar'] = 'test';

    $res = postJson($url, ['appMsg' => $data]);
    $res->assertJsonPath('msg', 'Done');
    $res->assertJsonPath('success', true);

    $res = postJson('api/common/appMsg/get');
    $res->assertJsonPath('appMsg', $data);
});
