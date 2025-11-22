<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin Access Middleware
 * 
 * Ensures user has admin role and 2FA enabled
 */
class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect()->route('admin.login');
        }

        // Check admin role
        $allowedRoles = ['super_admin', 'admin', 'moderator'];
        if (!in_array($user->role, $allowedRoles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403, 'Access denied');
        }

        // Check if user is active
        if (!$user->is_active) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Account suspended'], 403);
            }
            abort(403, 'Account suspended');
        }

        // Check IP whitelist if configured
        if (!empty($user->ip_whitelist)) {
            $allowedIPs = json_decode($user->ip_whitelist, true);
            if (!in_array($request->ip(), $allowedIPs)) {
                Log::channel('security')->warning('Admin access denied - IP not whitelisted', [
                    'user_id' => $user->id,
                    'ip' => $request->ip(),
                ]);
                abort(403, 'IP address not authorized');
            }
        }

        // Require 2FA for admin access
        if (!$user->hasTwoFactorEnabled() || !$request->session()->get('2fa_verified', false)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Two-factor authentication required',
                    'requires_2fa' => true,
                ], 403);
            }
            return redirect()->route('admin.2fa.verify');
        }

        return $next($request);
    }
}

