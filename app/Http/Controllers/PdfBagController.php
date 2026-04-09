<?php

namespace App\Http\Controllers;

use App\Models\PdfCategory;

class PdfBagController extends Controller
{
    // Show all categories
    public function index()
    {
        $categories = PdfCategory::orderBy('sort_order')->orderBy('id')->withCount('files')->get();
        return view('user.pdf-bag', compact('categories'));
    }

    // Show files inside a category
    public function category(PdfCategory $category)
    {
        $files = $category->files()->get();
        return view('user.pdf-bag-files', compact('category', 'files'));
    }
}
