<?php

use Saleh\LaravelAppCommon\Helpers\Distance;

test('get distance', function () {
    //0
    $result = Distance::get(24.713551, 46.675296, 24.713551, 46.675296);
    expect($result)->toBe(0);

    //0
    $result = Distance::get(24.713551, 46.675296, 25.713551, 47.675296);
    expect($result)->toBe(149.94797088295556);
});
