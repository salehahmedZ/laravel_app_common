<?php

namespace Saleh\LaravelAppCommon;

use Illuminate\Database\Eloquent\Model;

class LaravelAppCommon
{
    public static function user(): string
    {
        return config('app-common.userModel');
    }
}
