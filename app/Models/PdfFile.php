<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PdfFile extends Model
{
    protected $guarded = [];

    public function subcategory()
    {
        return $this->belongsTo(PdfSubcategory::class, 'pdf_subcategory_id');
    }

    public function category()
    {
        return $this->belongsTo(PdfCategory::class, 'pdf_category_id');
    }

    public function getUrlAttribute(): string
    {
        return asset('assets_front/pdfs/' . $this->filename);
    }

    public function getSizeAttribute(): string
    {
        $path = base_path('assets_front/pdfs/' . $this->filename);
        if (!file_exists($path)) return '-';
        $bytes = filesize($path);
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        return round($bytes / 1024, 0) . ' KB';
    }
}
