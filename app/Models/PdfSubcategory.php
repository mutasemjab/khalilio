<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BagExam;

class PdfSubcategory extends Model
{
    use HasFactory;
    
    protected $fillable = ['pdf_category_id', 'name_ar', 'name_en', 'icon', 'sort_order'];

    public function category()
    {
        return $this->belongsTo(PdfCategory::class, 'pdf_category_id');
    }

    public function files()
    {
        return $this->hasMany(PdfFile::class, 'pdf_subcategory_id');
    }

    public function exams()
    {
        return $this->hasMany(BagExam::class, 'pdf_subcategory_id');
    }

    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : ($this->name_en ?: $this->name_ar);
    }
}
