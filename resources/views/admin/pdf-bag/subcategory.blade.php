{{-- resources/views/admin/pdf-bag/subcategory.blade.php --}}
@extends('layouts.admin')
@section('title', 'ملفات: ' . $subcategory->name_ar)

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap" style="gap:12px">
        <div>
            <a href="{{ route('admin.pdf-bag.categories.show', $subcategory->pdf_category_id) }}"
               class="btn btn-sm btn-outline-secondary mb-2">
                <i class="fas fa-arrow-right mr-1"></i> العودة للتصنيفات الفرعية
            </a>
            <h4 class="mb-1 font-weight-bold">
                <span style="font-size:24px">{{ $subcategory->icon }}</span>
                {{ $subcategory->name_ar }}
            </h4>
            <p class="text-muted mb-0 small">إدارة ملفات PDF في هذا التصنيف الفرعي</p>
        </div>
        <div>
            <a href="{{ route('admin.bag-exams.index', $subcategory->id) }}" class="btn btn-primary">
                <i class="fas fa-file-alt mr-1"></i>
                إدارة الامتحانات
                @php $examsCount = $subcategory->exams()->count(); @endphp
                @if($examsCount > 0)
                <span class="badge badge-light ml-1">{{ $examsCount }}</span>
                @endif
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    {{-- Upload PDF --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: linear-gradient(135deg,#11998e,#38ef7d); color:white;">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-upload mr-2"></i> رفع ملف PDF جديد</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pdf-bag.files.store', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-5 form-group mb-md-0">
                        <label class="font-weight-bold small">عنوان الملف (اختياري)</label>
                        <input type="text" name="pdf_title" class="form-control" placeholder="مثال: ورقة عمل الوحدة الأولى">
                    </div>
                    <div class="col-md-1 form-group mb-md-0">
                        <label class="font-weight-bold small">الترتيب</label>
                        <input type="number" name="sort_order" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-md-4 form-group mb-md-0">
                        <label class="font-weight-bold small">اختر ملف PDF *</label>
                        <input type="file" name="pdf_file" accept=".pdf" class="form-control-file" required>
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
        <div class="card-header bg-white">
            <h6 class="mb-0 font-weight-bold">
                <i class="fas fa-file-pdf text-danger mr-2"></i>
                الملفات المرفوعة
                <span class="badge badge-secondary ml-2">{{ $files->count() }}</span>
            </h6>
        </div>
        <div class="card-body p-0">
            @if($files->count() > 0)
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>الحجم</th>
                            <th>تاريخ الرفع</th>
                            <th>الترتيب</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($files as $i => $file)
                        <tr>
                            <td class="text-muted align-middle">{{ $i + 1 }}</td>
                            <td class="align-middle">
                                <span style="font-size:18px">📄</span>
                                <strong class="mr-2">{{ $file->title }}</strong>
                                <small class="text-muted d-block" style="font-size:11px">{{ $file->filename }}</small>
                            </td>
                            <td class="align-middle"><span class="badge badge-light">{{ $file->size }}</span></td>
                            <td class="text-muted align-middle small">{{ $file->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-muted align-middle">{{ $file->sort_order }}</td>
                            <td class="align-middle">
                                <a href="{{ $file->url }}" target="_blank" class="btn btn-sm btn-outline-primary mr-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-secondary mr-1"
                                        data-toggle="collapse" data-target="#editFile{{ $file->id }}"
                                        title="تعديل الاسم">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.pdf-bag.files.destroy', $file->id) }}"
                                      method="POST" class="d-inline" id="del-file-{{ $file->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="pbConfirm('del-file-{{ $file->id }}', 'هل أنت متأكد من حذف الملف؟')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        {{-- Inline edit row --}}
                        <tr class="collapse bg-light" id="editFile{{ $file->id }}">
                            <td colspan="6" class="p-3">
                                <form action="{{ route('admin.pdf-bag.files.update', $file->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="row align-items-end">
                                        <div class="col-md-7 form-group mb-2">
                                            <label class="font-weight-bold small">عنوان الملف *</label>
                                            <input type="text" name="title" class="form-control form-control-sm"
                                                   value="{{ $file->title }}" required>
                                        </div>
                                        <div class="col-md-2 form-group mb-2">
                                            <label class="font-weight-bold small">الترتيب</label>
                                            <input type="number" name="sort_order" class="form-control form-control-sm"
                                                   value="{{ $file->sort_order }}" min="0">
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                            <button type="submit" class="btn btn-sm btn-success btn-block">
                                                <i class="fas fa-save mr-1"></i> حفظ العنوان
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        ملاحظة: تعديل الاسم لا يؤثر على ملف PDF المرفوع على القرص.
                                    </small>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-5 text-muted">
                    <div style="font-size:48px">📂</div>
                    <p class="mt-3">لا توجد ملفات في هذا التصنيف الفرعي بعد.</p>
                </div>
            @endif
        </div>
    </div>

</div>

<script>
function pbConfirm(formId, msg) {
    if (window.confirm(msg)) {
        document.getElementById(formId).submit();
    }
}
</script>
@endsection
