<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PdfCategory;
use App\Models\PdfFile;
use App\Models\PdfSubcategory;
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
        $categories = PdfCategory::orderBy('sort_order')->orderBy('id')
            ->withCount('subcategories')
            ->get();
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
        foreach ($category->subcategories as $sub) {
            foreach ($sub->files as $file) {
                $path = $this->dir . DIRECTORY_SEPARATOR . $file->filename;
                if (File::exists($path)) File::delete($path);
            }
        }
        $category->delete();
        return back()->with('success', 'تم حذف التصنيف وكل محتوياته.');
    }

    // ── Subcategories ─────────────────────────────────────────

    public function showCategory(PdfCategory $category)
    {
        $subcategories = $category->subcategories()->withCount('files')->get();
        return view('admin.pdf-bag.category', compact('category', 'subcategories'));
    }

    public function storeSubcategory(Request $request, PdfCategory $category)
    {
        $request->validate([
            'name_ar'    => 'required|string|max:200',
            'name_en'    => 'nullable|string|max:200',
            'icon'       => 'nullable|string|max:10',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        PdfSubcategory::create([
            'pdf_category_id' => $category->id,
            'name_ar'         => $request->name_ar,
            'name_en'         => $request->name_en,
            'icon'            => $request->icon ?: '📁',
            'sort_order'      => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'تم إضافة التصنيف الفرعي بنجاح.');
    }

    public function destroySubcategory(PdfSubcategory $subcategory)
    {
        foreach ($subcategory->files as $file) {
            $path = $this->dir . DIRECTORY_SEPARATOR . $file->filename;
            if (File::exists($path)) File::delete($path);
        }
        $subcategory->delete();
        return back()->with('success', 'تم حذف التصنيف الفرعي وملفاته.');
    }

    // ── Files ─────────────────────────────────────────────────

    public function showSubcategory(PdfSubcategory $subcategory)
    {
        $files = $subcategory->files()->orderBy('sort_order')->get();
        return view('admin.pdf-bag.subcategory', compact('subcategory', 'files'));
    }

    public function storeFile(Request $request, PdfSubcategory $subcategory)
    {
        $request->validate([
            'pdf_file'   => 'required|mimes:pdf|max:20480',
            'pdf_title'  => 'nullable|string|max:200',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $title    = $request->pdf_title
            ?: pathinfo($request->file('pdf_file')->getClientOriginalName(), PATHINFO_FILENAME);
        $slug     = Str::slug($title, '_');
        $filename = time() . '_' . $slug . '.pdf';

        if (!File::isDirectory($this->dir)) {
            File::makeDirectory($this->dir, 0755, true);
        }

        $request->file('pdf_file')->move($this->dir, $filename);

        PdfFile::create([
            'pdf_subcategory_id' => $subcategory->id,
            'title'              => $title,
            'filename'           => $filename,
            'sort_order'         => $request->sort_order ?? 0,
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
