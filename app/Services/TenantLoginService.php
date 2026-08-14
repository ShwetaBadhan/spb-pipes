<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class TenantLoginService
{
    public function issueLoginToken(User $user, string $next): string
    {
        $expiresAt = Carbon::now()->addHour();

        $payload = json_encode([
            'uid' => $user->id,
            'next' => $next,
            'exp' => $expiresAt->timestamp,
        ]);

        $token = Crypt::encryptString($payload);
        Cache::store()->put("auth.login.{$token}", $user->id, $expiresAt);

        return $token;
    }

    public function tenantUrl(string $domain, string $path = ''): string
    {
        $scheme = app()->environment('production') ? 'https' : 'http';
        $port = app()->environment('production') ? '' : ':8000';

        return $scheme . '://' . $domain . $port . $path;
    }
}
