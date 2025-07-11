<?php

namespace App\Http\Middleware\Api\v1;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Parse token and get payload
            $payload = JWTAuth::parseToken()->getPayload();

            // Get user id from sub
            $userId = $payload->get('sub');

            // You can also store any other info you want from the payload
            $request->merge(['user_id' => (int) $userId]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        return $next($request);
    }
}
