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
        // Cek apakah ada 'supabase_token' di dalam session
        if (!session()->has('supabase_token')) {
            // Kalau nggak ada, arahin ke halaman login dan kasih pesan error
            return redirect()->route('login')->withErrors(['error' => 'Kamu harus login dulu bro!']);
        }

        // Kalau ada, biarin dia lanjut buka halamannya
        return $next($request);
    }
}