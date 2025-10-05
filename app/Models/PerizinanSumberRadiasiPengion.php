<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanSumberRadiasiPengion extends Model
{
    use HasFactory;

    protected $table = 'perizinan_sumber_radiasi_pengion';

    protected $fillable = [
        'project_id',
        'nama',
        'tipe',
        'no_seri',
        'aktivitas',
        'tanggal_aktivitas',
        'kv_ma',
        'no_ktun',
        'tanggal_berlaku',
    ];

    protected $casts = [
        'tanggal_aktivitas' => 'date',
        'tanggal_berlaku' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
