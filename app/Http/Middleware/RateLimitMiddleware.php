<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rate Limiting Middleware
 * 
 * Implements tiered rate limiting for different endpoints:
 * - Login: 5 attempts per minute
 * - Registration: 3 attempts per minute
 * - API: 60 requests per hour
 * - General: 100 requests per minute
 * 
 * @package App\Http\Middleware
 */
class RateLimitMiddleware
{
    /**
     * Rate limit configurations
     */
    private array $rateLimits = [
        'login' => ['maxAttempts' => 5, 'decayMinutes' => 1],
        'register' => ['maxAttempts' => 3, 'decayMinutes' => 1],
        'api' => ['maxAttempts' => 60, 'decayMinutes' => 60],
        'otp' => ['maxAttempts' => 5, 'decayMinutes' => 15],
        'password-reset' => ['maxAttempts' => 3, 'decayMinutes' => 15],
        'default' => ['maxAttempts' => 100, 'decayMinutes' => 1],
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $type
     */
    public function handle(Request $request, Closure $next, ?string $type = 'default'): Response
    {
        $type = $type ?? 'default';
        $config = $this->rateLimits[$type] ?? $this->rateLimits['default'];
        
        $key = $this->resolveRequestSignature($request, $type);
        
        $executed = RateLimiter::attempt(
            $key,
            $config['maxAttempts'],
            function () use ($next, $request) {
                return $next($request);
            },
            $config['decayMinutes'] * 60
        );

        if (!$executed) {
            // Log rate limit violation
            Log::channel('security')->warning('Rate limit exceeded', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'endpoint' => $request->path(),
                'type' => $type,
                'max_attempts' => $config['maxAttempts'],
            ]);

            return response()->json([
                'message' => 'Too many requests. Please try again later.',
                'retry_after' => RateLimiter::availableIn($key),
            ], 429)->withHeaders([
                'Retry-After' => RateLimiter::availableIn($key),
                'X-RateLimit-Limit' => $config['maxAttempts'],
                'X-RateLimit-Remaining' => 0,
            ]);
        }

        $response = $next($request);
        
        // Add rate limit headers
        $remaining = RateLimiter::remaining($key, $config['maxAttempts']);
        $response->headers->set('X-RateLimit-Limit', $config['maxAttempts']);
        $response->headers->set('X-RateLimit-Remaining', max(0, $remaining));

        return $response;
    }

    /**
     * Resolve request signature for rate limiting
     *
     * @param Request $request
     * @param string $type
     * @return string
     */
    protected function resolveRequestSignature(Request $request, string $type): string
    {
        $identifier = $request->user()?->id ?? $request->ip();
        return sha1($type . '|' . $identifier . '|' . $request->path());
    }
}
