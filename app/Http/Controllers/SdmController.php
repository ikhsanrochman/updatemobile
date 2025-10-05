<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\KetersediaanSdm;
use App\Http\Controllers\Controller;
use App\Models\Project;

class SdmController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('super_admin.ketersediaan_sdm', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'users' => 'required|array'
        ]);

        $ketersediaan_sdm = KetersediaanSdm::create([
            'project_id' => $request->project_id
        ]);

        $ketersediaan_sdm->users()->attach($request->users);

        return redirect()->route('super_admin.ketersediaan_sdm')->with('success', 'Ketersediaan SDM berhasil ditambahkan.');
    }

    public function detail($id)
    {
        $project = Project::with('ketersediaanSdm.users')->findOrFail($id);
        
        // Get all users that are not already in this project's ketersediaan_sdm
        $existingUserIds = $project->ketersediaanSdm->flatMap->users->pluck('id')->unique();
        $availableUsers = User::whereNotIn('id', $existingUserIds)
            ->with('jenisPekerja')
            ->get();
            
        return view('super_admin.ketersediaan_sdm_detail', compact('project', 'availableUsers'));
    }

    public function addUser(Request $request, $projectId)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        $project = Project::findOrFail($projectId);
        
        // Create new ketersediaan_sdm record if it doesn't exist
        $ketersediaanSdm = $project->ketersediaanSdm()->firstOrCreate([
            'project_id' => $projectId
        ]);

        // Attach users to ketersediaan_sdm
        $ketersediaanSdm->users()->attach($request->users);

        return redirect()->route('super_admin.ketersediaan_sdm.detail', $projectId)
            ->with('success', 'SDM berhasil ditambahkan ke project.');
    }

    public function removeUser($projectId, $userId)
    {
        $project = Project::findOrFail($projectId);
        $ketersediaanSdm = $project->ketersediaanSdm()->first();
        
        if ($ketersediaanSdm) {
            $ketersediaanSdm->users()->detach($userId);
        }

        return redirect()->route('super_admin.ketersediaan_sdm.detail', $projectId)
            ->with('success', 'SDM berhasil dihapus dari project.');
    }
}
