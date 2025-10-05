<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
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

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil ditambahkan!');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $project->update($request->all());

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil diperbarui!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $projects = Project::when($search, function($query) use ($search) {
                $query->where('nama_proyek', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);
        $table = view('admin.projects.search', compact('projects'))->render();
        $pagination = $projects->links()->render();
        $info = 'Menampilkan ' . ($projects->firstItem() ?? 0) . ' sampai ' . ($projects->lastItem() ?? 0) . ' dari ' . $projects->total() . ' data';
        return response()->json([
            'html' => [
                'table' => $table,
                'pagination' => $pagination,
                'info' => $info,
            ]
        ]);
    }

    public function show(Project $project)
    {
        // Tidak ada halaman detail, redirect ke index
        return redirect()->route('admin.projects.index');
    }

    // Method lain bisa ditambahkan sesuai kebutuhan resource
} 