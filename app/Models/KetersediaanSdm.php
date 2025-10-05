<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KetersediaanSdm extends Model
{
    use HasFactory;

    protected $table = 'ketersediaan_sdm';

    protected $fillable = [
        'project_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'ketersediaan_sdm_users');
    }
}
