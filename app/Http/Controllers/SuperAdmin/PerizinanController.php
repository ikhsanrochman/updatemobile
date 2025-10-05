<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\PerizinanSumberRadiasiPengion;
use Illuminate\Support\Facades\DB;

class PerizinanController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('super_admin.perizinan.index', compact('projects'));
    }

    public function create($project_id)
    {
        $project = Project::findOrFail($project_id);
        return view('super_admin.perizinan.create', compact('project'));
    }

    public function detail($id)
    {
        $project = Project::findOrFail($id);
        $perizinanSumberRadiasiPengion = $project->perizinanSumberRadiasiPengion;
        return view('super_admin.perizinan.detail', compact('project', 'perizinanSumberRadiasiPengion'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'no_seri' => 'required|string|max:255',
            'aktivitas' => 'required|string|max:255',
            'tanggal_aktivitas' => 'required|date',
            'kv_ma' => 'nullable|string|max:255',
            'no_ktun' => 'required|string|max:255',
            'tanggal_berlaku' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $perizinan = PerizinanSumberRadiasiPengion::create([
                'project_id' => $request->project_id,
                'nama' => $request->nama,
                'tipe' => $request->tipe,
                'no_seri' => $request->no_seri,
                'aktivitas' => $request->aktivitas,
                'tanggal_aktivitas' => $request->tanggal_aktivitas,
                'kv_ma' => $request->kv_ma,
                'no_ktun' => $request->no_ktun,
                'tanggal_berlaku' => $request->tanggal_berlaku,
            ]);

            DB::commit();

            return redirect()
                ->route('super_admin.perizinan.detail', $perizinan->project_id)
                ->with('success', 'Data perizinan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $perizinan = PerizinanSumberRadiasiPengion::findOrFail($id);
        return view('super_admin.perizinan.edit', compact('perizinan'));
    }

    public function update(Request $request, $id)
    {
        $perizinan = PerizinanSumberRadiasiPengion::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'no_seri' => 'required|string|max:255',
            'aktivitas' => 'required|string|max:255',
            'tanggal_aktivitas' => 'required|date',
            'kv_ma' => 'nullable|string|max:255',
            'no_ktun' => 'required|string|max:255',
            'tanggal_berlaku' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $perizinan->update($request->all());

            DB::commit();

            return redirect()
                ->route('super_admin.perizinan.detail', $perizinan->project_id)
                ->with('success', 'Data perizinan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $perizinan = PerizinanSumberRadiasiPengion::findOrFail($id);
            $project_id = $perizinan->project_id;
            $perizinan->delete();

            DB::commit();

            return redirect()
                ->route('super_admin.perizinan.detail', $project_id)
                ->with('success', 'Data perizinan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);

        $projects = Project::when($query, function($q) use ($query) {
                $q->where('nama_proyek', 'like', '%' . $query . '%')
                  ->orWhere('keterangan', 'like', '%' . $query . '%');
            })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        $table = view('super_admin.perizinan.search', compact('projects'))->render();
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
} 