<?php

namespace Saleh\LaravelAppCommon;

use Illuminate\Database\Eloquent\Model;

class LaravelAppCommon
{
    public static function user(): Model
    {
        return config('app-common.userModel');
    }
}
