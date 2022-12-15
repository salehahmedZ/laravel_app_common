<?php

namespace Saleh\LaravelAppCommon\Helpers;

use Illuminate\Support\Facades\Cache;

class ContactUs
{
    private string $key = 'contactUs';

    public function set($data): bool
    {
        return Cache::forever($this->key, $data);
    }

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
