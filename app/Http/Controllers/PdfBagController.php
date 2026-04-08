<?php
// app/Http/Controllers/PdfBagController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class PdfBagController extends Controller
{
    public function index()
    {
        $dir   = base_path('assets_front/pdfs');
        $files = [];

        if (File::isDirectory($dir)) {
            foreach (File::files($dir) as $file) {
                if (strtolower($file->getExtension()) === 'pdf') {
                    $files[] = [
                        'name' => $file->getFilenameWithoutExtension(),
                        'url'  => asset('assets_front/pdfs/' . $file->getFilename()),
                        'size' => $this->formatSize($file->getSize()),
                        'date' => date('Y-m-d', $file->getMTime()),
                    ];
                }
            }
        }

        // Newest first
        usort($files, fn($a, $b) => strcmp($b['date'], $a['date']));

        return view('user.pdf-bag', compact('files'));
    }

    private function formatSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }
        return round($bytes / 1024, 0) . ' KB';
    }
}
