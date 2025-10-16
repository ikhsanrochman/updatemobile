<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PemantauanDosisPendose;
use App\Models\PemantauanDosisTld;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemantauanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $projects = Project::with('ketersediaanSdm.users')
            ->get()
            ->filter(function ($project) use ($user) {
                return $project->ketersediaanSdm->flatMap->users->contains('id', $user->id);
            });

        return view('user.pemantauan.index', [
            'projects' => $projects,
        ]);
    }

    public function detail($projectId)
    {
        $project = $this->ensureUserInProject($projectId);
        $userId = Auth::id();

        $tlds = PemantauanDosisTld::where('project_id', $project->id)
            ->where('user_id', $userId)
            ->orderByDesc('tanggal_pemantauan')
            ->get();

        $pendoses = PemantauanDosisPendose::where('project_id', $project->id)
            ->where('user_id', $userId)
            ->orderByDesc('tanggal_pengukuran')
            ->get();

        return view('user.pemantauan.detail', compact('project', 'tlds', 'pendoses'));
    }

    // TLD
    public function tldCreate($projectId)
    {
        $project = $this->ensureUserInProject($projectId);
        return view('user.pemantauan.tld.create', compact('project'));
    }

    public function tldStore(Request $request, $projectId)
    {
        $project = $this->ensureUserInProject($projectId);
        $validated = $request->validate([
            'tanggal_pemantauan' => 'required|date',
            'dosis' => 'required|numeric|min:0',
        ]);

        $userId = Auth::id();

        $existing = PemantauanDosisTld::where([
            'project_id' => $project->id,
            'user_id' => $userId,
            'tanggal_pemantauan' => $validated['tanggal_pemantauan'],
        ])->first();
        if ($existing) {
            return back()->withInput()->with('error', 'Data dosis TLD untuk tanggal ini sudah ada.');
        }

        DB::beginTransaction();
        try {
            PemantauanDosisTld::create([
                'user_id' => $userId,
                'project_id' => $project->id,
                'tanggal_pemantauan' => $validated['tanggal_pemantauan'],
                'dosis' => $validated['dosis'],
            ]);
            DB::commit();
            return redirect()->route('user.pemantauan.detail', $project->id)->with('success', 'Data TLD berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function tldEdit($projectId, $dosisId)
    {
        $project = $this->ensureUserInProject($projectId);
        $userId = Auth::id();
        $dosisTld = PemantauanDosisTld::where('id', $dosisId)->where('user_id', $userId)->where('project_id', $project->id)->firstOrFail();
        return view('user.pemantauan.tld.edit', compact('project', 'dosisTld'));
    }

    public function tldUpdate(Request $request, $projectId, $dosisId)
    {
        $project = $this->ensureUserInProject($projectId);
        $userId = Auth::id();
        $validated = $request->validate([
            'tanggal_pemantauan' => 'required|date',
            'dosis' => 'required|numeric|min:0',
        ]);
        $dosisTld = PemantauanDosisTld::where('id', $dosisId)->where('user_id', $userId)->where('project_id', $project->id)->firstOrFail();

        $duplicate = PemantauanDosisTld::where('project_id', $project->id)
            ->where('user_id', $userId)
            ->where('tanggal_pemantauan', $validated['tanggal_pemantauan'])
            ->where('id', '!=', $dosisId)
            ->first();
        if ($duplicate) {
            return back()->withInput()->with('error', 'Data dosis TLD untuk tanggal ini sudah ada.');
        }

        $dosisTld->update([
            'tanggal_pemantauan' => $validated['tanggal_pemantauan'],
            'dosis' => $validated['dosis'],
        ]);

        return redirect()->route('user.pemantauan.detail', $project->id)->with('success', 'Data TLD berhasil diperbarui');
    }

    public function tldDestroy($projectId, $dosisId)
    {
        $project = $this->ensureUserInProject($projectId);
        $userId = Auth::id();
        $dosisTld = PemantauanDosisTld::where('id', $dosisId)->where('user_id', $userId)->where('project_id', $project->id)->firstOrFail();
        $dosisTld->delete();
        return redirect()->route('user.pemantauan.detail', $project->id)->with('success', 'Data TLD berhasil dihapus');
    }

    // Pendose
    public function pendosCreate($projectId)
    {
        $project = $this->ensureUserInProject($projectId);
        return view('user.pemantauan.pendos.create', compact('project'));
    }

    public function pendosStore(Request $request, $projectId)
    {
        $project = $this->ensureUserInProject($projectId);
        $validated = $request->validate([
            'tanggal_pemantauan' => 'required|date',
            'dosis' => 'required|numeric|min:0',
        ]);
        $userId = Auth::id();

        $existing = PemantauanDosisPendose::where([
            'project_id' => $project->id,
            'user_id' => $userId,
            'tanggal_pengukuran' => $validated['tanggal_pemantauan'],
        ])->first();
        if ($existing) {
            return back()->withInput()->with('error', 'Data dosis Pendose untuk tanggal ini sudah ada.');
        }

        DB::beginTransaction();
        try {
            PemantauanDosisPendose::create([
                'user_id' => $userId,
                'project_id' => $project->id,
                'tanggal_pengukuran' => $validated['tanggal_pemantauan'],
                'hasil_pengukuran' => $validated['dosis'],
                'jenis_alat_pemantauan' => 'Pendos',
            ]);
            DB::commit();
            return redirect()->route('user.pemantauan.detail', $project->id)->with('success', 'Data Pendose berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function pendosEdit($projectId, $dosisId)
    {
        $project = $this->ensureUserInProject($projectId);
        $userId = Auth::id();
        $dosisPendos = PemantauanDosisPendose::where('id', $dosisId)->where('user_id', $userId)->where('project_id', $project->id)->firstOrFail();
        return view('user.pemantauan.pendos.edit', compact('project', 'dosisPendos'));
    }

    public function pendosUpdate(Request $request, $projectId, $dosisId)
    {
        $project = $this->ensureUserInProject($projectId);
        $userId = Auth::id();
        $validated = $request->validate([
            'tanggal_pemantauan' => 'required|date',
            'dosis' => 'required|numeric|min:0',
        ]);
        $dosisPendos = PemantauanDosisPendose::where('id', $dosisId)->where('user_id', $userId)->where('project_id', $project->id)->firstOrFail();

        $duplicate = PemantauanDosisPendose::where('project_id', $project->id)
            ->where('user_id', $userId)
            ->where('tanggal_pengukuran', $validated['tanggal_pemantauan'])
            ->where('id', '!=', $dosisId)
            ->first();
        if ($duplicate) {
            return back()->withInput()->with('error', 'Data dosis Pendose untuk tanggal ini sudah ada.');
        }

        $dosisPendos->update([
            'tanggal_pengukuran' => $validated['tanggal_pemantauan'],
            'hasil_pengukuran' => $validated['dosis'],
        ]);

        return redirect()->route('user.pemantauan.detail', $project->id)->with('success', 'Data Pendose berhasil diperbarui');
    }

    public function pendosDestroy($projectId, $dosisId)
    {
        $project = $this->ensureUserInProject($projectId);
        $userId = Auth::id();
        $dosisPendos = PemantauanDosisPendose::where('id', $dosisId)->where('user_id', $userId)->where('project_id', $project->id)->firstOrFail();
        $dosisPendos->delete();
        return redirect()->route('user.pemantauan.detail', $project->id)->with('success', 'Data Pendose berhasil dihapus');
    }

    private function ensureUserInProject(int $projectId): Project
    {
        $user = Auth::user();
        $project = Project::with('ketersediaanSdm.users')->findOrFail($projectId);
        $allowed = $project->ketersediaanSdm->flatMap->users->contains('id', $user->id);
        abort_unless($allowed, 403, 'Anda tidak terdaftar pada project ini.');
        return $project;
    }
}


