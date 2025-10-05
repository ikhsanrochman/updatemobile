<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class SdmController extends Controller
{    public function index()
    {
        $projects = Project::with('ketersediaanSdm.users')->paginate(10);
        return view('admin.sdm.index', compact('projects'));
    }

    public function create($id)
    {
        $project = Project::findOrFail($id);
        
        // Get all users that are not already in this project's ketersediaan_sdm
        $existingUserIds = $project->ketersediaanSdm->flatMap->users->pluck('id')->unique();
        $availableUsers = User::whereNotIn('id', $existingUserIds)
            ->with('jenisPekerja')
            ->get();
            
        return view('admin.sdm.create', compact('project', 'availableUsers'));
    }

    public function detail($id)
    {
        $project = Project::with('ketersediaanSdm.users')->findOrFail($id);
        
        // Get all users that are not already in this project's ketersediaan_sdm
        $existingUserIds = $project->ketersediaanSdm->flatMap->users->pluck('id')->unique();
        $availableUsers = User::whereNotIn('id', $existingUserIds)
            ->with('jenisPekerja')
            ->get();
            
        return view('admin.sdm.detail', compact('project', 'availableUsers'));
    }

    public function removeUser($project, $id)
    {
        try {
            $project = Project::findOrFail($project);
            $ketersediaanSdm = $project->ketersediaanSdm()->firstOrFail();
            
            // Detach specific user from ketersediaan_sdm
            $ketersediaanSdm->users()->detach($id);

            return response()->json([
                'success' => true,
                'message' => 'Pekerja berhasil dihapus dari project'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function searchUsers(Request $request)
    {
        $search = $request->input('search');
        $projectId = $request->input('project_id');

        // Get the project
        $project = Project::findOrFail($projectId);
        
        // Get existing user IDs in this project
        $existingUserIds = $project->ketersediaanSdm->flatMap->users->pluck('id')->unique();

        // Search for users not in this project
        $users = User::whereNotIn('id', $existingUserIds)
            ->where('nama', 'like', "%{$search}%")
            ->with('jenisPekerja')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'nama' => $user->nama,
                    'jenis_pekerja' => $user->jenisPekerja->pluck('nama')->first(),
                    'no_sib' => $user->no_sib,
                    'berlaku' => $user->berlaku,
                    'keahlian' => $user->keahlian
                ];
            });

        return response()->json($users);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        try {
            $project = Project::findOrFail($id);
            
            // Create or get ketersediaan_sdm record
            $ketersediaanSdm = $project->ketersediaanSdm()->firstOrCreate([
                'project_id' => $project->id
            ]);

            // Attach user to ketersediaan_sdm
            $ketersediaanSdm->users()->attach($request->user_id);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Data pekerja berhasil ditambahkan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($projectId, $workerId)
    {
        try {
            $project = Project::findOrFail($projectId);
            $ketersediaanSdm = $project->ketersediaanSdm()->firstOrFail();
            
            // Detach user from ketersediaan_sdm
            $ketersediaanSdm->users()->detach($workerId);

            return response()->json([
                'success' => true,
                'message' => 'Pekerja berhasil dihapus dari project'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $projects = Project::when($search, function($q) use ($search) {
                $q->where('nama_proyek', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);
        $table = view('admin.sdm.search', compact('projects'))->render();
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
