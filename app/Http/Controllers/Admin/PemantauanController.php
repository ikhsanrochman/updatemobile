<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\PemantauanDosisTld;
use App\Models\PemantauanDosisPendose;
use App\Models\PemantauanDosisPendos;
use Illuminate\Support\Facades\DB;

class PemantauanController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(10);
        return view('admin.pemantauan.index', compact('projects'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $projects = Project::where('nama_proyek', 'LIKE', "%{$search}%")
            ->orWhere('keterangan', 'LIKE', "%{$search}%")
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.pemantauan.search', compact('projects'))->render()
            ]);
        }

        return view('admin.pemantauan.index', compact('projects'));
    }

    public function tld($id)
    {
        $project = Project::with('ketersediaanSdm.users')->findOrFail($id);
        $dosisTlds = PemantauanDosisTld::where('project_id', $id)->get();
        
        $users = $project->ketersediaanSdm->flatMap->users->unique('id');

        // Prepare user data as JSON string in the controller
        $projectUsersJson = $users->map(function($user) {
            return [
                'id' => $user->id,
                'nama' => $user->nama,
                'npr' => $user->npr,
                'pemantauanDosisTld' => $user->pemantauanDosisTld->map(function($dosis) {
                    return [
                        'tanggal_pemantauan' => $dosis->tanggal_pemantauan,
                        'dosis' => $dosis->dosis,
                        'year' => substr($dosis->tanggal_pemantauan, 0, 4)
                    ];
                })->toArray()
            ];
        })->toJson();

        return view('admin.pemantauan.tld.tld', compact('project', 'dosisTlds', 'projectUsersJson'));
    }

    public function pendos(Project $project)
    {
        // Ambil semua user yang terlibat di project melalui ketersediaanSdm
        $users = $project->ketersediaanSdm->flatMap->users->unique('id');

        // Pre-process the data for easier JS access
        $projectUsers = $users->map(function($user) {
            // Group dosis by year and sum them
            $dosisByYear = $user->pemantauanDosisPendose->groupBy(function($dosis) {
                return substr($dosis->tanggal_pengukuran, 0, 4);
            })->map(function($doses) {
                return $doses->sum('hasil_pengukuran');
            });

            return [
                'id' => $user->id,
                'nama' => $user->nama,
                'npr' => $user->npr,
                'pemantauanDosisPendos' => $dosisByYear->map(function($total, $year) {
                    return [
                        'year' => $year,
                        'dosis' => $total
                    ];
                })->values()->toArray()
            ];
        });

        // Calculate total dosis for each year
        $yearlyTotals = [];
        foreach ($users as $user) {
            foreach ($user->pemantauanDosisPendose as $dosis) {
                $year = substr($dosis->tanggal_pengukuran, 0, 4);
                if (!isset($yearlyTotals[$year])) {
                    $yearlyTotals[$year] = 0;
                }
                $yearlyTotals[$year] += $dosis->hasil_pengukuran;
            }
        }

        $projectUsersJson = json_encode($projectUsers);

        return view('admin.pemantauan.pendos.pendos', compact('project', 'projectUsersJson', 'yearlyTotals'));
    }

    public function tldDetail($projectId, $userId)
    {
        $project = Project::with('ketersediaanSdm.users')->findOrFail($projectId);
        $user = $project->ketersediaanSdm->flatMap->users->where('id', $userId)->firstOrFail();
        $dosisTlds = $user->pemantauanDosisTld; // Get all TLD doses for this user

        return view('admin.pemantauan.tld.detail', compact('project', 'user', 'dosisTlds'));
    }

    public function tldCreate($projectId)
    {
        $project = Project::with('ketersediaanSdm.users')->findOrFail($projectId);
        return view('admin.pemantauan.tld.create', compact('project'));
    }

    public function tldStore(Request $request, $projectId)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'tanggal_pemantauan' => 'required|date',
                'dosis' => 'required|numeric|min:0',
            ]);

            // Check for duplicate entry
            $existingDosis = PemantauanDosisTld::where([
                'project_id' => $projectId,
                'user_id' => $validated['user_id'],
                'tanggal_pemantauan' => $validated['tanggal_pemantauan']
            ])->first();

            if ($existingDosis) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data dosis untuk tanggal ini sudah ada. Silakan pilih tanggal lain atau edit data yang sudah ada.');
            }

            DB::beginTransaction();

            try {
                $dosis = PemantauanDosisTld::create([
                    'user_id' => $validated['user_id'],
                    'project_id' => $projectId,
                    'tanggal_pemantauan' => $validated['tanggal_pemantauan'],
                    'dosis' => $validated['dosis'],
                ]);

                DB::commit();

                return redirect()
                    ->route('admin.tld.user.detail', ['projectId' => $projectId, 'userId' => $validated['user_id']])
                    ->with('success', 'Data dosis berhasil ditambahkan');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Error creating TLD record: ' . $e->getMessage());
                \Log::error('Request data: ' . json_encode($request->all()));
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Validation error: ' . $e->getMessage());
            \Log::error('Request data: ' . json_encode($request->all()));
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function tldEdit($projectId, $userId, $dosisId)
    {
        $project = Project::with('ketersediaanSdm.users')->findOrFail($projectId);
        $user = $project->ketersediaanSdm->flatMap->users->where('id', $userId)->firstOrFail();
        $dosisTld = PemantauanDosisTld::findOrFail($dosisId);

        return view('admin.pemantauan.tld.edit', compact('project', 'user', 'dosisTld'));
    }

    public function tldUpdate(Request $request, $projectId, $userId, $dosisId)
    {
        try {
            $validated = $request->validate([
                'tanggal_pemantauan' => 'required|date',
                'dosis' => 'required|numeric|min:0',
            ]);

            $dosisTld = PemantauanDosisTld::findOrFail($dosisId);

            // Check for duplicate entry, excluding current record
            $existingDosis = PemantauanDosisTld::where([
                'project_id' => $projectId,
                'user_id' => $userId,
                'tanggal_pemantauan' => $validated['tanggal_pemantauan']
            ])->where('id', '!=', $dosisId)->first();

            if ($existingDosis) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data dosis untuk tanggal ini sudah ada. Silakan pilih tanggal lain.');
            }

            DB::beginTransaction();

            $dosisTld->update([
                'tanggal_pemantauan' => $validated['tanggal_pemantauan'],
                'dosis' => $validated['dosis'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.tld.user.detail', ['projectId' => $projectId, 'userId' => $userId])
                ->with('success', 'Data dosis berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function tldDestroy($projectId, $userId, $dosisId)
    {
        try {
            $dosisTld = PemantauanDosisTld::findOrFail($dosisId);

            DB::beginTransaction();
            $dosisTld->delete();
            DB::commit();

            return redirect()
                ->route('admin.tld.user.detail', ['projectId' => $projectId, 'userId' => $userId])
                ->with('success', 'Data dosis berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pendosCreate($projectId)
    {
        $project = Project::findOrFail($projectId);
        return view('admin.pemantauan.pendos.create', compact('project'));
    }

    public function pendosStore(Request $request, $projectId)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'tanggal_pemantauan' => 'required|date',
                'dosis' => 'required|numeric|min:0',
            ]);

            // Check for duplicate entry
            $existingDosis = PemantauanDosisPendose::where([
                'project_id' => $projectId,
                'user_id' => $validated['user_id'],
                'tanggal_pengukuran' => $validated['tanggal_pemantauan']
            ])->first();

            if ($existingDosis) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data dosis untuk tanggal ini sudah ada. Silakan pilih tanggal lain atau edit data yang sudah ada.');
            }

            DB::beginTransaction();

            try {
                $dosis = PemantauanDosisPendose::create([
                    'user_id' => $validated['user_id'],
                    'project_id' => $projectId,
                    'tanggal_pengukuran' => $validated['tanggal_pemantauan'],
                    'hasil_pengukuran' => $validated['dosis'],
                    'jenis_alat_pemantauan' => 'Pendos', // Adding default value
                ]);

                DB::commit();

                return redirect()
                    ->route('admin.pemantauan.pendos', ['project' => $projectId])
                    ->with('success', 'Data dosis berhasil ditambahkan');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Error creating Pendos record: ' . $e->getMessage());
                \Log::error('Request data: ' . json_encode($request->all()));
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            \Log::error('Validation error in Pendos store: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi: ' . $e->getMessage());
        }
    }

    public function pendosDetail($projectId, $userId)
    {
        $project = Project::findOrFail($projectId);
        $user = $project->ketersediaanSdm->flatMap->users->where('id', $userId)->first();
        if (!$user) {
            abort(404, 'User tidak ditemukan dalam project ini');
        }
        $dosisData = $user->pemantauanDosisPendose()
            ->where('project_id', $project->id)
            ->orderBy('tanggal_pengukuran', 'desc')
            ->get();

        return view('admin.pemantauan.pendos.detail', compact('project', 'user', 'dosisData'));
    }

    public function pendosEdit($projectId, $userId, $dosisId)
    {
        $project = Project::findOrFail($projectId);
        $user = $project->ketersediaanSdm->flatMap->users->where('id', $userId)->first();
        if (!$user) {
            abort(404, 'User tidak ditemukan dalam project ini');
        }
        $dosisPendos = PemantauanDosisPendose::findOrFail($dosisId);

        return view('admin.pemantauan.pendos.edit', compact('project', 'user', 'dosisPendos'));
    }

    public function pendosUpdate(Request $request, $projectId, $userId, $dosisId)
    {
        try {
            $validated = $request->validate([
                'tanggal_pengukuran' => 'required|date',
                'hasil_pengukuran' => 'required|numeric|min:0',
            ]);

            $dosisPendos = PemantauanDosisPendose::findOrFail($dosisId);

            // Check for duplicate entry, excluding current record
            $existingDosis = PemantauanDosisPendose::where([
                'project_id' => $projectId,
                'user_id' => $userId,
                'tanggal_pengukuran' => $validated['tanggal_pengukuran']
            ])->where('id', '!=', $dosisId)->first();

            if ($existingDosis) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data dosis untuk tanggal ini sudah ada. Silakan pilih tanggal lain.');
            }

            DB::beginTransaction();

            $dosisPendos->update([
                'tanggal_pengukuran' => $validated['tanggal_pengukuran'],
                'hasil_pengukuran' => $validated['hasil_pengukuran'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.pendos.user.detail', ['projectId' => $projectId, 'userId' => $userId])
                ->with('success', 'Data dosis berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pendosDestroy($projectId, $userId, $dosisId)
    {
        try {
            $dosisPendos = PemantauanDosisPendose::findOrFail($dosisId);

            DB::beginTransaction();
            $dosisPendos->delete();
            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()
                ->route('admin.pendos.user.detail', ['projectId' => $projectId, 'userId' => $userId])
                ->with('success', 'Data dosis berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->ajax()) {
                return response()->json(['success' => false, 'error' => $e->getMessage()]);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}