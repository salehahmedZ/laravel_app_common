<?php

namespace Saleh\LaravelAppCommon\Helpers;

class Helpers
{
    public static function removeEmptyLines(string $string): string
    {
        return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);
    }
}
