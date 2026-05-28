<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $query = Language::query();

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $languages = $query->paginate(10)->appends($request->all());

        return view('superadmin.language.index', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:languages,nama'
        ]);

        $language = Language::create([
            'nama' => $request->nama
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bahasa berhasil ditambahkan',
            'data' => $language
        ]);
    }

    public function show($id)
    {
        $language = Language::findOrFail($id);
        return response()->json($language);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        $language = Language::findOrFail($id);
        $language->update([
            'nama' => $request->nama
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bahasa berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        $language->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bahasa berhasil dihapus'
        ]);
    }
}
