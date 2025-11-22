<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecurityEvent;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Security Dashboard Controller
 * 
 * Provides security monitoring and auditing interface for admins
 * 
 * @package App\Http\Controllers\Admin
 */
class SecurityDashboardController extends Controller
{
    /**
     * Display security dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = $this->getSecurityStats();
        $recentEvents = SecurityEvent::where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();
        
        $criticalEvents = SecurityEvent::where('severity', SecurityEvent::SEVERITY_CRITICAL)
            ->where('resolved', false)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $failedLoginAttempts = LoginAttempt::where('success', false)
            ->where('attempted_at', '>=', now()->subHours(24))
            ->orderBy('attempted_at', 'desc')
            ->limit(50)
            ->get();

        return view('admin.security.dashboard', [
            'stats' => $stats,
            'recentEvents' => $recentEvents,
            'criticalEvents' => $criticalEvents,
            'failedLoginAttempts' => $failedLoginAttempts,
        ]);
    }

    /**
     * Get security statistics
     *
     * @return array
     */
    private function getSecurityStats(): array
    {
        $last24Hours = now()->subHours(24);
        $last7Days = now()->subDays(7);
        $last30Days = now()->subDays(30);

        return [
            'events_24h' => SecurityEvent::where('created_at', '>=', $last24Hours)->count(),
            'events_7d' => SecurityEvent::where('created_at', '>=', $last7Days)->count(),
            'events_30d' => SecurityEvent::where('created_at', '>=', $last30Days)->count(),
            'critical_unresolved' => SecurityEvent::where('severity', SecurityEvent::SEVERITY_CRITICAL)
                ->where('resolved', false)
                ->count(),
            'failed_logins_24h' => LoginAttempt::where('success', false)
                ->where('attempted_at', '>=', $last24Hours)
                ->count(),
            'unique_ips_24h' => LoginAttempt::where('attempted_at', '>=', $last24Hours)
                ->distinct('ip_address')
                ->count('ip_address'),
            'events_by_severity' => SecurityEvent::where('created_at', '>=', $last7Days)
                ->select('severity', DB::raw('count(*) as count'))
                ->groupBy('severity')
                ->pluck('count', 'severity')
                ->toArray(),
            'events_by_type' => SecurityEvent::where('created_at', '>=', $last7Days)
                ->select('event_type', DB::raw('count(*) as count'))
                ->groupBy('event_type')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->pluck('count', 'event_type')
                ->toArray(),
        ];
    }

    /**
     * Mark security event as resolved
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resolveEvent(Request $request, int $id)
    {
        $event = SecurityEvent::findOrFail($id);
        
        $event->markAsResolved(auth()->id());

        return back()->with('success', 'Security event marked as resolved.');
    }

    /**
     * Get security events API (for AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents(Request $request)
    {
        $query = SecurityEvent::query();

        // Filter by severity
        if ($request->has('severity')) {
            $query->where('severity', $request->severity);
        }

        // Filter by event type
        if ($request->has('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        // Filter by resolved status
        if ($request->has('resolved')) {
            $query->where('resolved', $request->boolean('resolved'));
        }

        // Date range
        if ($request->has('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $events = $query->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json($events);
    }
}

