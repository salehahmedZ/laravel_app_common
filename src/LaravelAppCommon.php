<?php

namespace Saleh\LaravelAppCommon;

class LaravelAppCommon
{
    public static function user(): string
    {
        return config('app-common.userModel');
    }
}
