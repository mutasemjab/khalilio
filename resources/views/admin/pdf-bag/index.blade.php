{{-- resources/views/admin/pdf-bag/index.blade.php --}}
@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'الحقيبة الإلكترونية' : 'Digital Bag')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 font-weight-bold">
                <span style="font-size:24px">💼</span>
                {{ app()->getLocale() === 'ar' ? 'الحقيبة الإلكترونية' : 'Digital Bag' }}
            </h4>
            <p class="text-muted mb-0 small">
                {{ app()->getLocale() === 'ar' ? 'إدارة ملفات PDF المرفوعة' : 'Manage uploaded PDF files' }}
            </p>
        </div>
        <a href="{{ route('pdf-bag.index') }}" target="_blank" class="btn btn-outline-success btn-sm px-3">
            <i class="fas fa-external-link-alt mr-1"></i>
            {{ app()->getLocale() === 'ar' ? 'عرض الصفحة' : 'View Page' }}
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Upload Card --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: linear-gradient(135deg,#11998e,#38ef7d); color:white;">
            <h6 class="mb-0 font-weight-bold">
                <i class="fas fa-upload mr-2"></i>
                {{ app()->getLocale() === 'ar' ? 'رفع ملف PDF جديد' : 'Upload New PDF' }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pdf-bag.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-5 form-group mb-md-0">
                        <label class="font-weight-bold small">
                            {{ app()->getLocale() === 'ar' ? 'اسم الملف (اختياري)' : 'File Title (optional)' }}
                        </label>
                        <input type="text" name="pdf_title" class="form-control @error('pdf_title') is-invalid @enderror"
                               placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: ورقة عمل الوحدة الأولى' : 'e.g. Unit 1 Worksheet' }}">
                        @error('pdf_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-5 form-group mb-md-0">
                        <label class="font-weight-bold small">
                            {{ app()->getLocale() === 'ar' ? 'اختر ملف PDF *' : 'Choose PDF file *' }}
                        </label>
                        <input type="file" name="pdf_file" accept=".pdf"
                               class="form-control-file @error('pdf_file') is-invalid @enderror" required>
                        @error('pdf_file')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        <small class="text-muted">{{ app()->getLocale() === 'ar' ? 'الحد الأقصى: 20 MB' : 'Max: 20 MB' }}</small>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-upload mr-1"></i>
                            {{ app()->getLocale() === 'ar' ? 'رفع' : 'Upload' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Files Table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <h6 class="mb-0 font-weight-bold">
                <i class="fas fa-file-pdf text-danger mr-2"></i>
                {{ app()->getLocale() === 'ar' ? 'الملفات المرفوعة' : 'Uploaded Files' }}
                <span class="badge badge-secondary ml-2">{{ count($files) }}</span>
            </h6>
        </div>
        <div class="card-body p-0">
            @if(count($files) > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>{{ app()->getLocale() === 'ar' ? 'اسم الملف' : 'File Name' }}</th>
                                <th>{{ app()->getLocale() === 'ar' ? 'الحجم' : 'Size' }}</th>
                                <th>{{ app()->getLocale() === 'ar' ? 'تاريخ الرفع' : 'Upload Date' }}</th>
                                <th>{{ app()->getLocale() === 'ar' ? 'إجراءات' : 'Actions' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $i => $file)
                                <tr>
                                    <td class="text-muted">{{ $i + 1 }}</td>
                                    <td>
                                        <span style="font-size:18px">📄</span>
                                        <strong class="mr-2">{{ $file['name'] }}</strong>
                                    </td>
                                    <td><span class="badge badge-light">{{ $file['size'] }}</span></td>
                                    <td class="text-muted small">{{ $file['date'] }}</td>
                                    <td>
                                        <a href="{{ $file['url'] }}" target="_blank"
                                           class="btn btn-sm btn-outline-primary mr-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.pdf-bag.destroy', $file['filename']) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من الحذف؟' : 'Delete this file?' }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <div style="font-size:48px">📂</div>
                    <p class="mt-3">{{ app()->getLocale() === 'ar' ? 'لا توجد ملفات مرفوعة بعد.' : 'No files uploaded yet.' }}</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
