<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Two-Factor Authentication Middleware
 * 
 * Ensures 2FA is verified for protected routes
 */
class CheckTwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip if no user or 2FA not enabled
        if (!$user || !$user->hasTwoFactorEnabled()) {
            return $next($request);
        }

        // Check if 2FA is verified in session
        if (!$request->session()->get('2fa_verified', false)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Two-factor authentication required',
                    'requires_2fa' => true,
                ], 403);
            }

            return redirect()->route('2fa.verify');
        }

        return $next($request);
    }
}

