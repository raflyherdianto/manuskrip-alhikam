<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index(Request $request)
    {
        $query = Prodi::with('jurusan');

        // Filter by jurusan if provided
        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhereHas('jurusan', function($q2) use ($search) {
                      $q2->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $prodis = $query->paginate(10)->appends($request->all());

        return response()->json($prodis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        // Check if prodi already exists for this jurusan
        $exists = Prodi::where('nama', $request->nama)
            ->where('jurusan_id', $request->jurusan_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Program Studi dengan nama ini sudah ada untuk jurusan yang dipilih'
            ], 422);
        }

        $prodi = Prodi::create([
            'nama' => $request->nama,
            'jurusan_id' => $request->jurusan_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Program Studi berhasil ditambahkan',
            'data' => $prodi->load('jurusan')
        ]);
    }

    public function show($id)
    {
        $prodi = Prodi::with('jurusan')->findOrFail($id);
        return response()->json($prodi);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        $prodi = Prodi::findOrFail($id);

        // Check if prodi already exists for this jurusan (excluding current)
        $exists = Prodi::where('nama', $request->nama)
            ->where('jurusan_id', $request->jurusan_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Program Studi dengan nama ini sudah ada untuk jurusan yang dipilih'
            ], 422);
        }

        $prodi->update([
            'nama' => $request->nama,
            'jurusan_id' => $request->jurusan_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Program Studi berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);

        // Check if there are users associated with this prodi
        if ($prodi->users()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Program Studi tidak dapat dihapus karena masih digunakan oleh user'
            ], 400);
        }

        $prodi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Program Studi berhasil dihapus'
        ]);
    }

    /**
     * Get prodis by jurusan id (for AJAX calls)
     */
    public function getByJurusan($jurusanId)
    {
        $prodis = Prodi::where('jurusan_id', $jurusanId)
            ->orderBy('nama')
            ->get();

        return response()->json($prodis);
    }
}
