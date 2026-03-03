<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController
{
    private $supabaseUrl;
    private $supabaseKey;

    public function __construct()
    {
        // Ngambil data dari .env yang barusan kamu setting
        $this->supabaseUrl = env('SUPABASE_URL');
        $this->supabaseKey = env('SUPABASE_ANON_KEY');
    }

    // --- TAMPILAN FORM ---
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // --- PROSES REGISTER KE SUPABASE ---
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6', // Supabase minimal 6 karakter
        ]);

        // Nembak API Supabase Auth buat Signup
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->supabaseUrl}/auth/v1/signup", [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            // Kalau sukses, arahin ke halaman login
            return redirect()->route('login')->with('success', 'Berhasil daftar! Silakan login.');
        }

        // Kalau gagal (misal email udah kepake)
        $errorMsg = $response->json()['msg'] ?? 'Gagal Register';
        return back()->withErrors(['error' => $errorMsg]);
    }

    // --- PROSES LOGIN KE SUPABASE ---
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Nembak API Supabase Auth buat dapetin Token
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->supabaseUrl}/auth/v1/token?grant_type=password", [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            // Simpan data penting ke Session Laravel
            session(['supabase_token' => $data['access_token']]);
            session(['user_id' => $data['user']['id']]); // Ini UUID dari auth.users
            session(['user_email' => $data['user']['email']]);

            // Bawa masuk ke dashboard
            return redirect('/'); 
        }

        return back()->withErrors(['error' => 'Email atau Password salah bro!']);
    }

    // --- PROSES LOGOUT ---
    public function logout()
    {
        // Hapus semua data dari session
        session()->forget(['supabase_token', 'user_id', 'user_email']);
        return redirect()->route('login');
    }
}