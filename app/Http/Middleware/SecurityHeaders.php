<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '0');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Embedder-Policy', 'credentialless');

        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; "
            . "script-src 'self' 'unsafe-eval' 'unsafe-inline' https://www.googletagmanager.com https://cdnjs.cloudflare.com https://challenges.cloudflare.com; "
            . "style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://cdnjs.cloudflare.com; "
            . "font-src 'self' https://fonts.bunny.net; "
            . "img-src 'self' data: blob: https:; "
            . "connect-src 'self' https:; "
            . "frame-src 'self' https://challenges.cloudflare.com; "
            . "frame-ancestors 'self'; "
            . "base-uri 'self'; "
            . "form-action 'self'; "
            . "upgrade-insecure-requests"
        );

        if (app()->isProduction()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }
}
