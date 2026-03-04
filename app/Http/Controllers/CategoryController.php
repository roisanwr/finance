<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController
{
    // --- VIEW / HALAMAN ---
    public function view()
    {
        return view('fiat.categories');
    }

    // --- API ENDPOINTS ---

    /**
     * Get semua category milik user yang ter-login
     */
    public function index()
    {
        $userId = session('user_id');

        $categories = Category::where('user_id', $userId)
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($categories);
    }

    /**
     * Tambah category baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:PEMASUKAN,PENGELUARAN,TRANSFER',
        ]);

        $userId = session('user_id');

        // Cek duplikasi nama kategori untuk tipe yang sama
        $exists = Category::where('user_id', $userId)
            ->where('name', $request->name)
            ->where('type', $request->type)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori dengan nama dan tipe ini sudah ada.'
            ], 422);
        }

        $category = Category::create([
            'id' => (string)Str::uuid(),
            'user_id' => $userId,
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    /**
     * Update category
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:PEMASUKAN,PENGELUARAN,TRANSFER',
        ]);

        $userId = session('user_id');

        $category = Category::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404);
        }

        // Cek duplikasi nama (ngecek kategori lain)
        $exists = Category::where('user_id', $userId)
            ->where('name', $request->name)
            ->where('type', $request->type)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori dengan nama dan tipe ini sudah ada.'
            ], 422);
        }

        $category->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    /**
     * Hapus category
     */
    public function destroy($id)
    {
        $userId = session('user_id');

        $category = Category::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
}