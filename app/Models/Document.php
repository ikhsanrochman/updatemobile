<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_dokumen',
        'topik',
        'file_path',
        'deskripsi',
        'document_category_id',
    ];

    public function documentCategory()
    {
        return $this->belongsTo(DocumentCategory::class);
    }
}
