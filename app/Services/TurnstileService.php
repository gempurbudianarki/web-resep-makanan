<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TurnstileService
{
    private string $secretKey;
    private string $verifyUrl = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    public function __construct()
    {
        $this->secretKey = config('services.turnstile.secret_key');
    }

    public function validate(string $token, ?string $ip = null): bool
    {
        if (empty($token)) {
            return false;
        }

        try {
            $response = Http::timeout(5)
                ->asForm()
                ->post($this->verifyUrl, [
                    'secret' => $this->secretKey,
                    'response' => $token,
                    'remoteip' => $ip ?? request()->ip(),
                ]);

            $data = $response->json();

            return ($data['success'] ?? false) === true;
        } catch (\Exception $e) {
            Log::warning('Turnstile verification failed: ' . $e->getMessage());
            return false;
        }
    }
}
