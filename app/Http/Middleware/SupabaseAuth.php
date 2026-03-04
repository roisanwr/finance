<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SupabaseAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('supabase_token')) {
            // Untuk request API (dari JS fetch), kembalikan JSON 401
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
            }

            // Untuk request halaman web, redirect ke login
            return redirect()->route('login')->withErrors(['error' => 'Kamu harus login dulu bro!']);
        }

        return $next($request);
    }
}