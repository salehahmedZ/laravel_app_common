<?php

use Saleh\LaravelAppCommon\Helpers\Countries;

test('get countries', function () {
    //valid code
    $result = Countries::getArNameUsingCode('SA');
    expect($result)->toBe('السعودية'); //valid code

    //case insensitive
    $result = Countries::getArNameUsingCode('sa');
    expect($result)->toBe('السعودية');

    //not exist code
    $result = Countries::getArNameUsingCode('AW');
    expect($result)->toBe(null);

    //valid
    $result = Countries::getArNameUsingEnName('Saudi Arabia');
    expect($result)->toBe('السعودية');

    //case insensitive
    $result = Countries::getArNameUsingEnName('SaudI arabia');
    expect($result)->toBe('السعودية');

    //not exits
    $result = Countries::getArNameUsingEnName('not exist');
    expect($result)->toBe(null);

    //valid
    $result = Countries::getCodeByEnName('Saudi Arabia');
    expect($result)->toBe('SA');

    //case insensitive
    $result = Countries::getCodeByEnName('saudi arabiA');
    expect($result)->toBe('SA');

    //not exits
    $result = Countries::getCodeByEnName('not exist');
    expect($result)->toBe(null);

    //synonyms
    $result = Countries::getEnArSynonyms();
    expect($result)->toBeArray()->toHaveLength(219);
});
