<?php

namespace App\Http\Controllers\Admin;

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
        $projects = Project::with([
            'perizinanSumberRadiasiPengion',
            'ketersediaanSdm.users',
            'pemantauanDosisTld',
            'pemantauanDosisPendose'
        ])->get();

        $totalProjects = $projects->count();
        $totalPerizinan = PerizinanSumberRadiasiPengion::count();
        $totalSdm = KetersediaanSdm::count();
        $totalTld = PemantauanDosisTld::count();
        $totalPendose = PemantauanDosisPendose::count();

        return view('admin.laporan.index', compact(
            'projects',
            'totalProjects',
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

        return view('admin.laporan.project_detail', compact('project'));
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
        $pdf = Pdf::loadView('admin.laporan.project_detail_pdf', compact('project'));
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'Laporan_Detail_Proyek_' . str_replace(' ', '_', $project->nama_proyek) . '_' . date('Y-m-d_H-i-s') . '.pdf';
        
        // Download the PDF
        return $pdf->download($filename);
    }

    public function downloadProjectDetail($id)
    {
        $project = Project::with([
            'perizinanSumberRadiasiPengion',
            'ketersediaanSdm.users',
            'pemantauanDosisTld.user',
            'pemantauanDosisPendose'
        ])->findOrFail($id);

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.project_detail_pdf', compact('project'));
        $pdf->setPaper('A4', 'portrait');
        $filename = 'Laporan_Detail_Proyek_' . str_replace(' ', '_', $project->nama_proyek) . '_' . date('Y-m-d_H-i-s') . '.pdf';
        return $pdf->download($filename);
    }
} 