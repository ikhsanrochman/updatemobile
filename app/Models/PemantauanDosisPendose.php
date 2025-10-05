<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemantauanDosisPendose extends Model
{
    use HasFactory;

    protected $table = 'pemantauan_dosis_pendose';

    protected $fillable = [
        'project_id',
        'user_id',
        'npr',
        'jenis_alat_pemantauan',
        'hasil_pengukuran',
        'tanggal_pengukuran',
        'kartu_dosis'
    ];

    protected $casts = [
        'tanggal_pengukuran' => 'date',
        'kartu_dosis' => 'boolean',
        'hasil_pengukuran' => 'double'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 