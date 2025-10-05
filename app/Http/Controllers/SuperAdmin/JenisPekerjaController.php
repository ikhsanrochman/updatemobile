<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisPekerja;

class JenisPekerjaController extends Controller
{
    public function list()
    {
        return response()->json(JenisPekerja::select('id', 'nama')->orderBy('nama')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_pekerja,nama',
        ]);
        $bidang = JenisPekerja::create(['nama' => $request->nama]);
        return response()->json(['success' => true, 'bidang' => $bidang]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_pekerja,nama,' . $id,
        ]);
        $bidang = JenisPekerja::findOrFail($id);
        $bidang->nama = $request->nama;
        $bidang->save();
        return response()->json(['success' => true, 'bidang' => $bidang]);
    }

    public function destroy($id)
    {
        $bidang = JenisPekerja::findOrFail($id);
        $bidang->delete();
        return response()->json(['success' => true]);
    }
} 