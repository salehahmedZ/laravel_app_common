<?php

namespace Saleh\LaravelAppCommon\Helpers;

use Illuminate\Support\Facades\Cache;

class AppMsg
{
    private string $key = 'appMsg';

    private array $default = [
        'text' => [
            'ar' => '',
            'en' => '',
        ],
        'type' => 'success',
        'os' => 'both',
        'forBuild' => 0,
        'forBuildOperator' => '',
        'countryCode' => 'all',
    ];

    public function set($data): bool
    {
        return Cache::forever($this->key, $data);
    }

    public function get(): array
    {
        $data = Cache::get($this->key, $this->default);

        $ar = $data['text']['ar'] ?? '';
        $en = $data['text']['en'] ?? '';

        return [
            'text' => [
                'ar' => $ar,
                'en' => $en,
            ],
            'type' => $data['type'] ?? $this->default['type'],
            'os' => $data['os'] ?? $this->default['os'],
            'forBuild' => (int) ($data['forBuild'] ?? $this->default['forBuild']),
            'forBuildOperator' => $data['forBuildOperator'] ?? $this->default['forBuildOperator'],
            'countryCode' => $data['countryCode'] ?? $this->default['countryCode'],
        ];
    }
}
