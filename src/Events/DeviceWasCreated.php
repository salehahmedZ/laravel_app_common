<?php

namespace Saleh\LaravelAppCommon\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Saleh\LaravelAppCommon\Models\Device;

class DeviceWasCreated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public Device $device)
    {
        //
    }
}
