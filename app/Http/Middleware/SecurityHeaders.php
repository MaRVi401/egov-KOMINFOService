<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 1. Mencegah Clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // 2. Mencegah MIME Sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 3. Proteksi XSS Dasar
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // 4. Referrer Policy
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');

        // 5. Menghapus X-Powered-By (Cara Laravel)
        $response->headers->remove('X-Powered-By');
        
        // 6. HSTS (Hanya jika HTTPS)
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // 7. Permissions Policy (Opsional - membatasi fitur browser seperti kamera/mikrofon)
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        return $response;
    }
}