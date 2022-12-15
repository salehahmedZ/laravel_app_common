<?php

namespace Saleh\LaravelAppCommon\Helpers;

use Illuminate\Support\Facades\Cache;

class AppVersion
{
    private string $key = 'appVersion';

    public function set($data): bool
    {
        return Cache::forever($this->key, $data);
    }

    public function get(): array
    {
        $data = Cache::get($this->key, []);

        return [
            'ios' => (int) ($data['ios'] ?? 0),
            'android' => (int) ($data['android'] ?? 0),
            'forceUpdate' => (bool) ($data['forceUpdate'] ?? false),
        ];
    }
}
