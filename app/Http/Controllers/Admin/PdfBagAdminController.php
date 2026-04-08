<?php
// app/Http/Controllers/Admin/PdfBagAdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function index()
    {
        $files = [];

        if (File::isDirectory($this->dir)) {
            foreach (File::files($this->dir) as $file) {
                if (strtolower($file->getExtension()) === 'pdf') {
                    $files[] = [
                        'filename' => $file->getFilename(),
                        'name'     => $file->getFilenameWithoutExtension(),
                        'url'      => asset('assets_front/pdfs/' . $file->getFilename()),
                        'size'     => $this->formatSize($file->getSize()),
                        'date'     => date('Y-m-d H:i', $file->getMTime()),
                    ];
                }
            }
        }

        usort($files, fn($a, $b) => strcmp($b['date'], $a['date']));

        return view('admin.pdf-bag.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdf_file'  => 'required|mimes:pdf|max:20480',
            'pdf_title' => 'nullable|string|max:200',
        ]);

        $title    = $request->pdf_title
            ? Str::slug($request->pdf_title, '_')
            : pathinfo($request->file('pdf_file')->getClientOriginalName(), PATHINFO_FILENAME);

        $filename = time() . '_' . $title . '.pdf';

        if (!File::isDirectory($this->dir)) {
            File::makeDirectory($this->dir, 0755, true);
        }

        $request->file('pdf_file')->move($this->dir, $filename);

        return back()->with('success', app()->getLocale() === 'ar'
            ? 'تم رفع الملف بنجاح.'
            : 'File uploaded successfully.');
    }

    public function destroy(string $filename)
    {
        $path = $this->dir . DIRECTORY_SEPARATOR . basename($filename);

        if (File::exists($path)) {
            File::delete($path);
        }

        return back()->with('success', app()->getLocale() === 'ar'
            ? 'تم حذف الملف.'
            : 'File deleted.');
    }

    private function formatSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }
        return round($bytes / 1024, 0) . ' KB';
    }
}
