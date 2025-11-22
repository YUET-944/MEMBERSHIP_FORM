<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Security Headers Middleware
 * 
 * Implements enterprise-grade security headers including:
 * - HSTS (HTTP Strict Transport Security)
 * - Content Security Policy (CSP) with nonce support
 * - XSS Protection
 * - Frame Options
 * - Referrer Policy
 * - Permissions Policy
 * 
 * @package App\Http\Middleware
 */
class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Generate nonce for CSP (Content Security Policy)
        $nonce = base64_encode(Str::random(32));

        // Store nonce in request for use in views
        $request->attributes->set('csp_nonce', $nonce);

        // HSTS (HTTP Strict Transport Security)
        // Only in production with HTTPS
        if (config('app.env') === 'production' && $request->secure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        // XSS Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Frame Options (prevent clickjacking)
        $response->headers->set('X-Frame-Options', 'DENY');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy (formerly Feature Policy)
        $response->headers->set(
            'Permissions-Policy',
            'geolocation=(), microphone=(), camera=(), payment=(), usb=(), magnetometer=(), gyroscope=(), speaker=()'
        );

        // Content Security Policy (CSP)
        $csp = $this->buildCSP($nonce);
        $response->headers->set('Content-Security-Policy', $csp);

        // X-Permitted-Cross-Domain-Policies
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // Remove server information
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }

    /**
     * Build Content Security Policy string
     *
     * @param string $nonce
     * @return string
     */
    private function buildCSP(string $nonce): string
    {
        $cspDirectives = [
            "default-src 'self'",
            "script-src 'self' 'nonce-{$nonce}' 'strict-dynamic' https://cdn.jsdelivr.net https://unpkg.com",
            "style-src 'self' 'nonce-{$nonce}' https://fonts.googleapis.com https://cdn.jsdelivr.net",
            "font-src 'self' https://fonts.gstatic.com data:",
            "img-src 'self' data: https: blob:",
            "connect-src 'self' " . config('app.url'),
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-src 'none'",
            "object-src 'none'",
            "upgrade-insecure-requests",
        ];

        return implode('; ', $cspDirectives);
    }
}

