<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_proyek',
        'keterangan',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date'
    ];

    public function ketersediaanSdm()
    {
        return $this->hasMany(KetersediaanSdm::class);
    }

    // public function users()
    // {
    //     // Relasi ini tidak dipakai langsung untuk mengambil SDM project.
    //     // Gunakan $project->ketersediaanSdm->flatMap->users->unique('id') untuk mengambil SDM yang terlibat di project.
    //     return $this->belongsToMany(User::class, 'ketersediaan_sdm_users', 'ketersediaan_sdm_id', 'user_id')
    //         ->whereHas('ketersediaanSdm', function($query) {
    //             $query->where('project_id', $this->id);
    //         });
    // }

    public function pemantauanDosisPendose()
    {
        return $this->hasMany(PemantauanDosisPendose::class);
    }

    public function perizinanSumberRadiasiPengion()
    {
        return $this->hasMany(PerizinanSumberRadiasiPengion::class);
    }

    public function pemantauanDosisTld()
    {
        return $this->hasMany(\App\Models\PemantauanDosisTld::class);
    }

    // Tambahkan relasi pengangkutan jika ada
}
