<?php

namespace App\Http\Middleware;

use App\Models\ApiClient;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiClientAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json(['message' => 'API key is required'], 401);
        }

        $client = ApiClient::where('key', $apiKey)
            ->where('is_active', true)
            ->first();

        if (!$client) {
            return response()->json(['message' => 'Invalid or inactive API key'], 403);
        }

        // ✅ Store client in request for later use
        $request->attributes->set('api_client', $client);

        return $next($request);
    }
}
