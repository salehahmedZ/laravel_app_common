<?php

use ColorThief\ColorThief;
use function Pest\Laravel\mock;
use function Pest\testDirectory;
use Saleh\LaravelAppCommon\Helpers\DominantColor;

test('Get Dominant Color', function () {
    //null
    $result = DominantColor::get(null);
    expect($result)->toBe(null);

    $path = testDirectory('Unit/data/1.jpg');

    //local path jpg
    $result = DominantColor::get($path);
    expect($result)->toBe('dac9c5');

    //url png
    $path = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png';
    $result = DominantColor::get($path);
    expect($result)->toBe('ec4434');

    //not an image url
    $path = 'https://www.google.com';
    $result = DominantColor::get($path);
    expect($result)->toBe(null);
});

test('Get Dominant Color other method', function () {
    mock(ColorThief::class)->shouldReceive('getColor')->andReturn(null);

    //url png
    $path = 'https://upload.wikimedia.org/wikipedia/en/a/a9/Example.jpg';
    $result = DominantColor::get($path);
    expect($result)->toBe('cacacc');

    //local path jpg
    $path = testDirectory('Unit/data/1.jpg');
    $result = DominantColor::get($path);
    expect($result)->toBe('997062');

    //local path gif
    $path = testDirectory('Unit/data/2.gif');
    $result = DominantColor::get($path);
    expect($result)->toBe('1b4169');

    //local path png
    $path = testDirectory('Unit/data/3.png');
    $result = DominantColor::get($path);
    expect($result)->toBe('221e11');

    //not an image
    $path = 'https://www.google.com';
    $result = DominantColor::get($path);
    expect($result)->toBe(null);
});
