<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BagExam extends Model
{
    protected $fillable = [
        'pdf_subcategory_id',
        'title_ar', 'title_en',
        'description_ar', 'description_en',
        'duration_minutes', 'total_marks',
        'is_active', 'sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function subcategory()
    {
        return $this->belongsTo(PdfSubcategory::class, 'pdf_subcategory_id');
    }

    public function questions()
    {
        return $this->hasMany(BagExamQuestion::class);
    }

    public function attempts()
    {
        return $this->hasMany(BagExamAttempt::class);
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : ($this->title_en ?: $this->title_ar);
    }

    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : ($this->description_en ?: $this->description_ar);
    }

    public function currentGradesSum(): int
    {
        return (int) $this->questions()->sum('grade');
    }

    public function remainingMarks(): int
    {
        return max(0, $this->total_marks - $this->currentGradesSum());
    }
}
