{{-- resources/views/admin/pdf-bag/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'الحقيبة الإلكترونية - التصنيفات')

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 font-weight-bold">
                <span style="font-size:24px">💼</span>
                الحقيبة الإلكترونية — التصنيفات
            </h4>
            <p class="text-muted mb-0 small">أنشئ تصنيفات وأضف الملفات داخلها</p>
        </div>
        <a href="{{ route('pdf-bag.index') }}" target="_blank" class="btn btn-outline-success btn-sm px-3">
            <i class="fas fa-external-link-alt mr-1"></i> عرض الصفحة
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    {{-- Add Category --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: linear-gradient(135deg,#11998e,#38ef7d); color:white;">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-plus mr-2"></i> إضافة تصنيف جديد</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pdf-bag.categories.store') }}" method="POST">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-4 form-group mb-md-0">
                        <label class="font-weight-bold small">الاسم بالعربي *</label>
                        <input type="text" name="name_ar" class="form-control" placeholder="مثال: امتحانات سابقة" required>
                    </div>
                    <div class="col-md-3 form-group mb-md-0">
                        <label class="font-weight-bold small">الاسم بالإنجليزي</label>
                        <input type="text" name="name_en" class="form-control" placeholder="e.g. Past Exams">
                    </div>
                    <div class="col-md-2 form-group mb-md-0">
                        <label class="font-weight-bold small">الأيقونة (emoji)</label>
                        <input type="text" name="icon" class="form-control text-center" placeholder="📚" maxlength="5" value="📁">
                    </div>
                    <div class="col-md-1 form-group mb-md-0">
                        <label class="font-weight-bold small">الترتيب</label>
                        <input type="number" name="sort_order" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-plus mr-1"></i> إضافة
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Categories list --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <h6 class="mb-0 font-weight-bold">
                <i class="fas fa-folder text-warning mr-2"></i>
                التصنيفات الموجودة
                <span class="badge badge-secondary ml-2">{{ $categories->count() }}</span>
            </h6>
        </div>
        <div class="card-body p-0">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>الأيقونة</th>
                                <th>الاسم</th>
                                <th>التصنيفات الفرعية</th>
                                <th>الترتيب</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $i => $cat)
                            <tr>
                                <td class="text-muted align-middle">{{ $i + 1 }}</td>
                                <td class="align-middle" style="font-size:24px">{{ $cat->icon }}</td>
                                <td class="align-middle">
                                    <strong>{{ $cat->name_ar }}</strong>
                                    @if($cat->name_en)
                                        <small class="text-muted d-block">{{ $cat->name_en }}</small>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-info">{{ $cat->subcategories_count }} تصنيف</span>
                                </td>
                                <td class="text-muted align-middle">{{ $cat->sort_order }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('admin.pdf-bag.categories.show', $cat->id) }}"
                                       class="btn btn-sm btn-outline-primary mr-1">
                                        <i class="fas fa-folder-open"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-secondary mr-1"
                                            data-toggle="collapse" data-target="#editCat{{ $cat->id }}"
                                            title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.pdf-bag.categories.destroy', $cat->id) }}"
                                          method="POST" class="d-inline" id="del-cat-{{ $cat->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="pbConfirm('del-cat-{{ $cat->id }}', 'حذف التصنيف وجميع محتوياته؟')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            {{-- Inline edit row --}}
                            <tr class="collapse bg-light" id="editCat{{ $cat->id }}">
                                <td colspan="6" class="p-3">
                                    <form action="{{ route('admin.pdf-bag.categories.update', $cat->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="row align-items-end">
                                            <div class="col-md-4 form-group mb-2">
                                                <label class="font-weight-bold small">الاسم بالعربي *</label>
                                                <input type="text" name="name_ar" class="form-control form-control-sm"
                                                       value="{{ $cat->name_ar }}" required>
                                            </div>
                                            <div class="col-md-3 form-group mb-2">
                                                <label class="font-weight-bold small">الاسم بالإنجليزي</label>
                                                <input type="text" name="name_en" class="form-control form-control-sm"
                                                       value="{{ $cat->name_en }}">
                                            </div>
                                            <div class="col-md-2 form-group mb-2">
                                                <label class="font-weight-bold small">الأيقونة</label>
                                                <input type="text" name="icon" class="form-control form-control-sm text-center"
                                                       value="{{ $cat->icon }}" maxlength="5">
                                            </div>
                                            <div class="col-md-1 form-group mb-2">
                                                <label class="font-weight-bold small">الترتيب</label>
                                                <input type="number" name="sort_order" class="form-control form-control-sm"
                                                       value="{{ $cat->sort_order }}" min="0">
                                            </div>
                                            <div class="col-md-2 form-group mb-2">
                                                <button type="submit" class="btn btn-sm btn-success btn-block">
                                                    <i class="fas fa-save mr-1"></i> حفظ
                                                </button>
                                            </div>
                                        </div>
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
                    <p class="mt-3">لا توجد تصنيفات بعد. أضف أول تصنيف من الأعلى.</p>
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
