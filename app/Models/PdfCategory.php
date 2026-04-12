<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PdfCategory extends Model
{
    protected $guarded = [];

    public function subcategories()
    {
        return $this->hasMany(PdfSubcategory::class, 'pdf_category_id')->orderBy('sort_order');
    }


    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : ($this->name_en ?: $this->name_ar);
    }
}
