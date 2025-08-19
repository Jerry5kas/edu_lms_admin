<?php

namespace App\Http\Middleware;

use App\Models\RateLimit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    public function handle(Request $request, Closure $next, $maxRequests = 60, $period = 'minute'): Response
    {
        // Get API key from header
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json(['message' => 'API key required'], 401);
        }

        // Define window start (period: minute, hour, day)
        $now = Carbon::now();
        $windowStart = match ($period) {
            'hour' => $now->startOfHour(),
            'day' => $now->startOfDay(),
            default => $now->startOfMinute(),
        };

        // Find or create rate limit record
        $rateLimit = RateLimit::firstOrNew([
            'key' => $apiKey,
            'period' => $period,
        ]);

        if (!$rateLimit->exists || $rateLimit->window_started_at < $windowStart) {
            // Reset counter if new period started
            $rateLimit->window_started_at = $windowStart;
            $rateLimit->request_count = 0;
        }

        // Increment count
        $rateLimit->request_count++;

        if ($rateLimit->request_count > $maxRequests) {
            return response()->json([
                'message' => 'Rate limit exceeded',
                'limit' => $maxRequests,
                'period' => $period,
                'retry_after' => $windowStart->add($period == 'hour' ? 1 : ($period == 'day' ? 1 : 60), $period == 'day' ? 'days' : 'seconds')->diffInSeconds($now),
            ], 429);
        }

        $rateLimit->save();

        return $next($request);
    }
}
