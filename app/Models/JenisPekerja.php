<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPekerja extends Model
{
    protected $table = 'jenis_pekerja';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'nama'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'jenis_pekerja_user', 'jenis_pekerja_id', 'user_id');
    }
} 