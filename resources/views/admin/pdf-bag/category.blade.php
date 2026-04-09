{{-- resources/views/admin/pdf-bag/category.blade.php --}}
@extends('layouts.admin')

@section('title', 'ملفات: ' . $category->name_ar)

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('admin.pdf-bag.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="fas fa-arrow-right mr-1"></i> العودة للتصنيفات
            </a>
            <h4 class="mb-1 font-weight-bold">
                <span style="font-size:24px">{{ $category->icon }}</span>
                {{ $category->name_ar }}
            </h4>
            <p class="text-muted mb-0 small">إدارة ملفات PDF في هذا التصنيف</p>
        </div>
        <a href="{{ route('pdf-bag.category', $category->id) }}" target="_blank" class="btn btn-outline-success btn-sm px-3">
            <i class="fas fa-external-link-alt mr-1"></i> عرض الصفحة
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Upload PDF --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: linear-gradient(135deg,#11998e,#38ef7d); color:white;">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-upload mr-2"></i> رفع ملف PDF جديد</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pdf-bag.files.store', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-5 form-group mb-md-0">
                        <label class="font-weight-bold small">عنوان الملف (اختياري)</label>
                        <input type="text" name="pdf_title" class="form-control @error('pdf_title') is-invalid @enderror"
                               placeholder="مثال: ورقة عمل الوحدة الأولى">
                        @error('pdf_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-1 form-group mb-md-0">
                        <label class="font-weight-bold small">الترتيب</label>
                        <input type="number" name="sort_order" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-md-4 form-group mb-md-0">
                        <label class="font-weight-bold small">اختر ملف PDF *</label>
                        <input type="file" name="pdf_file" accept=".pdf"
                               class="form-control-file @error('pdf_file') is-invalid @enderror" required>
                        @error('pdf_file')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        <small class="text-muted">الحد الأقصى: 20 MB</small>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-upload mr-1"></i> رفع
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
                الملفات المرفوعة
                <span class="badge badge-secondary ml-2">{{ $files->count() }}</span>
            </h6>
        </div>
        <div class="card-body p-0">
            @if($files->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>اسم الملف</th>
                                <th>الحجم</th>
                                <th>تاريخ الرفع</th>
                                <th>الترتيب</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $i => $file)
                            <tr>
                                <td class="text-muted">{{ $i + 1 }}</td>
                                <td>
                                    <span style="font-size:18px">📄</span>
                                    <strong class="mr-2">{{ $file->title }}</strong>
                                    <small class="text-muted d-block">{{ $file->filename }}</small>
                                </td>
                                <td><span class="badge badge-light">{{ $file->size }}</span></td>
                                <td class="text-muted small">{{ $file->created_at->format('Y-m-d H:i') }}</td>
                                <td class="text-muted">{{ $file->sort_order }}</td>
                                <td>
                                    <a href="{{ $file->url }}" target="_blank"
                                       class="btn btn-sm btn-outline-primary mr-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.pdf-bag.files.destroy', $file->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                        @csrf @method('DELETE')
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
                    <p class="mt-3">لا توجد ملفات في هذا التصنيف بعد.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
