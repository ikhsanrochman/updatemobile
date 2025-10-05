<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemantauanDosisTld extends Model
{
    use HasFactory;

    protected $table = 'pemantauan_dosis_tld';

    protected $fillable = [
        'user_id',
        'project_id',
        'tanggal_pemantauan',
        'dosis',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pemantauan' => 'date:Y-m-d',
        'dosis' => 'decimal:2',
    ];

    /**
     * Get the user that owns the pemantauan dosis record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
