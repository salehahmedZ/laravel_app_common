<?php

use function Pest\Laravel\postJson;

$url = 'api/common/appVersion/set';

it('must Be Logged In')->mustBeAdmin($url);

test('set appVersion route', function () use ($url) {
    actingAsAdmin();

    $data = appVersion;
    $data['ios'] = 1;
    $data['forceUpdate'] = true;

    $res = postJson($url, ['appVersion' => $data]);
    $res->assertJsonPath('msg', 'Done');
    $res->assertJsonPath('success', true);

    $res = postJson('api/common/appVersion/get');
    $res->assertJsonPath('appVersion', $data);
});
