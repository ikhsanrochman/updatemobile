<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProyekController extends Controller
{
    public function index()
    {
        $proyeks = Project::latest()->paginate(10);
        return view('super_admin.proyek.index', compact('proyeks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        Project::create($request->all());

        return redirect()->route('super_admin.proyek')->with('success', 'Proyek berhasil ditambahkan!');
    }

    public function update(Request $request, Project $proyek)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $proyek->update($request->all());

        return redirect()->route('super_admin.proyek')->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroy(Project $proyek)
    {
        $proyek->delete();

        return redirect()->route('super_admin.proyek')->with('success', 'Proyek berhasil dihapus!');
    }
} 