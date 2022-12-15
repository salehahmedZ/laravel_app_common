<?php

use Saleh\LaravelAppCommon\Helpers\Helpers;

test('Helpers', function () {
    //text with new lines
    $text = 'Hello
    
    World
    
    Hi
    ';

    $result = Helpers::removeEmptyLines($text);
    expect($result)->toBe('Hello
    World
    Hi
    ');
});
