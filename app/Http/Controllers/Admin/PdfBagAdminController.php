<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PdfCategory;
use App\Models\PdfFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PdfBagAdminController extends Controller
{
    private string $dir;

    public function __construct()
    {
        $this->dir = base_path('assets_front/pdfs');
    }

    // ── Categories ───────────────────────────────────────────

    public function index()
    {
        $categories = PdfCategory::orderBy('sort_order')->orderBy('id')->withCount('files')->get();
        return view('admin.pdf-bag.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name_ar'    => 'required|string|max:200',
            'name_en'    => 'nullable|string|max:200',
            'icon'       => 'nullable|string|max:10',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        PdfCategory::create([
            'name_ar'    => $request->name_ar,
            'name_en'    => $request->name_en,
            'icon'       => $request->icon ?: '📁',
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'تم إضافة التصنيف بنجاح.');
    }

    public function destroyCategory(PdfCategory $category)
    {
        // Delete physical files
        foreach ($category->files as $file) {
            $path = $this->dir . DIRECTORY_SEPARATOR . $file->filename;
            if (File::exists($path)) File::delete($path);
        }

        $category->delete(); // cascades to pdf_files

        return back()->with('success', 'تم حذف التصنيف وملفاته.');
    }

    // ── Files ────────────────────────────────────────────────

    public function showCategory(PdfCategory $category)
    {
        $files = $category->files()->get();
        return view('admin.pdf-bag.category', compact('category', 'files'));
    }

    public function storeFile(Request $request, PdfCategory $category)
    {
        $request->validate([
            'pdf_file'   => 'required|mimes:pdf|max:20480',
            'pdf_title'  => 'nullable|string|max:200',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $title    = $request->pdf_title
            ? $request->pdf_title
            : pathinfo($request->file('pdf_file')->getClientOriginalName(), PATHINFO_FILENAME);

        $slug     = Str::slug($title, '_');
        $filename = time() . '_' . $slug . '.pdf';

        if (!File::isDirectory($this->dir)) {
            File::makeDirectory($this->dir, 0755, true);
        }

        $request->file('pdf_file')->move($this->dir, $filename);

        PdfFile::create([
            'pdf_category_id' => $category->id,
            'title'           => $title,
            'filename'        => $filename,
            'sort_order'      => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'تم رفع الملف بنجاح.');
    }

    public function destroyFile(PdfFile $file)
    {
        $path = $this->dir . DIRECTORY_SEPARATOR . $file->filename;
        if (File::exists($path)) File::delete($path);
        $file->delete();

        return back()->with('success', 'تم حذف الملف.');
    }
}
