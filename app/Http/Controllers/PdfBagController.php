<?php

namespace App\Http\Controllers;

use App\Models\PdfCategory;
use App\Models\PdfSubcategory;

class PdfBagController extends Controller
{
    public function index()
    {
        $categories = PdfCategory::orderBy('sort_order')->orderBy('id')
            ->withCount('subcategories')
            ->get();
        return view('user.pdf-bag', compact('categories'));
    }

    public function category(PdfCategory $category)
    {
        $subcategories = $category->subcategories()->withCount('files')->get();
        return view('user.pdf-bag-category', compact('category', 'subcategories'));
    }

    public function subcategory(PdfCategory $category, PdfSubcategory $subcategory)
    {
        $files = $subcategory->files()->orderBy('sort_order')->get();
        return view('user.pdf-bag-files', compact('category', 'subcategory', 'files'));
    }
}
