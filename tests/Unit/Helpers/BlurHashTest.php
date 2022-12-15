<?php

use function Pest\testDirectory;
use Saleh\LaravelAppCommon\Helpers\BlurHash;

test('get blurhash', function () {
    //null
    $blurHash = BlurHash::make(null);
    expect($blurHash)->toBe(null);

    $path = testDirectory('Unit/data/1.jpg');

    //local path jpg
    $blurHash = BlurHash::make($path);
    expect($blurHash)->toBe('LMK,T~-=px}xtk-;IUX,%ixKS]+#');

    //url png
    $path = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png';
    $blurHash = BlurHash::make($path);
    expect($blurHash)->toBe('LnG9wSnXENOuY%aMi]e.49nNwFvz');

    //not an image url
    $path = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp';
    $blurHash = BlurHash::make($path);
    expect($blurHash)->toBe(null);
});
