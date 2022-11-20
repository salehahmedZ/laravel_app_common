<?php

namespace Saleh\LaravelAppCommon\Helpers;

use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\ArrayShape;

class ContactUs
{
    private string $key = 'contactUs';

    public function set($data): bool
    {
        return Cache::forever($this->key, $data);
    }

    #[ArrayShape([
        'whatsapp' => 'string',
        'twitter' => 'string',
        'snapchat' => 'string',
        'email' => 'string',
        'instagram' => 'string',
    ])]
    public function get(): array
    {
        $data = Cache::get($this->key, []);

        return [
            'whatsapp' => (string) ($data['whatsapp'] ?? ''),
            'twitter' => (string) ($data['twitter'] ?? ''),
            'snapchat' => (string) ($data['snapchat'] ?? ''),
            'email' => (string) ($data['email'] ?? ''),
            'instagram' => (string) ($data['instagram'] ?? ''),
        ];
    }
}
