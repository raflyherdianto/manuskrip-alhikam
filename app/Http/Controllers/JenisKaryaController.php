<?php

namespace App\Http\Controllers;

use App\Models\JenisKarya;
use Illuminate\Http\Request;

class JenisKaryaController extends Controller
{
    public function index()
    {
        $jenisKaryas = JenisKarya::withCount('karyas')
            ->orderBy('nama', 'asc')
            ->paginate(10);

        return response()->json([
            'html' => view('superadmin.jenis-karya.table', compact('jenisKaryas'))->render(),
            'pagination' => $jenisKaryas->links('vendor.pagination.custom')->render()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_karyas,nama'
        ]);

        JenisKarya::create([
            'nama' => $request->nama
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jenis manuskrip berhasil ditambahkan'
        ]);
    }

    public function show($id)
    {
        $jenisKarya = JenisKarya::withCount('karyas')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $jenisKarya
        ]);
    }

    public function update(Request $request, $id)
    {
        $jenisKarya = JenisKarya::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_karyas,nama,' . $id
        ]);

        $jenisKarya->update([
            'nama' => $request->nama
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jenis manuskrip berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $jenisKarya = JenisKarya::findOrFail($id);

        if ($jenisKarya->karyas()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis manuskrip tidak dapat dihapus karena masih digunakan oleh manuskrip'
            ], 400);
        }

        $jenisKarya->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jenis manuskrip berhasil dihapus'
        ]);
    }
}
