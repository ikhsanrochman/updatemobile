<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\PerizinanSumberRadiasiPengion;
use App\Models\KetersediaanSdm;
use App\Models\PemantauanDosisTld;
use App\Models\PemantauanDosisPendose;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        // Get all projects with their related data
        $projects = Project::with([
            'perizinanSumberRadiasiPengion',
            'ketersediaanSdm',
            'pemantauanDosisTld',
            'pemantauanDosisPendose'
        ])->get();

        // Calculate statistics
        $totalProjects = $projects->count();
        $activeProjects = $projects->where('status', 'active')->count();
        $completedProjects = $projects->where('status', 'completed')->count();
        
        // Count total perizinan
        $totalPerizinan = PerizinanSumberRadiasiPengion::count();
        
        // Count total SDM
        $totalSdm = KetersediaanSdm::count();
        
        // Count total pemantauan TLD
        $totalTld = PemantauanDosisTld::count();
        
        // Count total pemantauan Pendose
        $totalPendose = PemantauanDosisPendose::count();

        return view('super_admin.laporan.index', compact(
            'projects',
            'totalProjects',
            'activeProjects',
            'completedProjects',
            'totalPerizinan',
            'totalSdm',
            'totalTld',
            'totalPendose'
        ));
    }

    public function projectDetail($id)
    {
        $project = Project::with([
            'perizinanSumberRadiasiPengion',
            'ketersediaanSdm.users',
            'pemantauanDosisTld.user',
            'pemantauanDosisPendose'
        ])->findOrFail($id);

        return view('super_admin.laporan.project_detail', compact('project'));
    }

    public function downloadProjectReport($id)
    {
        $project = Project::with([
            'perizinanSumberRadiasiPengion',
            'ketersediaanSdm.users',
            'pemantauanDosisTld.user',
            'pemantauanDosisPendose'
        ])->findOrFail($id);

        // Generate PDF
        $pdf = Pdf::loadView('super_admin.laporan.project_detail_pdf', compact('project'));
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'Laporan_Detail_Proyek_' . str_replace(' ', '_', $project->nama_proyek) . '_' . date('Y-m-d_H-i-s') . '.pdf';
        
        // Download the PDF
        return $pdf->download($filename);
    }
} 