<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PdfCategory extends Model
{
    protected $guarded = [];

    public function files(): HasMany
    {
        return $this->hasMany(PdfFile::class)->orderBy('sort_order')->orderBy('created_at');
    }

    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : ($this->name_en ?: $this->name_ar);
    }
}
