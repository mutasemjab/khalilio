{{-- resources/views/admin/pdf-bag/category.blade.php --}}
@extends('layouts.admin')
@section('title', 'تصنيفات فرعية: ' . $category->name_ar)

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
            <p class="text-muted mb-0 small">إدارة التصنيفات الفرعية</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Add Subcategory --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: linear-gradient(135deg,#11998e,#38ef7d); color:white;">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-plus mr-2"></i> إضافة تصنيف فرعي جديد</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pdf-bag.subcategories.store', $category->id) }}" method="POST">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-4 form-group mb-md-0">
                        <label class="font-weight-bold small">الاسم بالعربي *</label>
                        <input type="text" name="name_ar" class="form-control" required>
                    </div>
                    <div class="col-md-3 form-group mb-md-0">
                        <label class="font-weight-bold small">الاسم بالإنجليزي</label>
                        <input type="text" name="name_en" class="form-control">
                    </div>
                    <div class="col-md-2 form-group mb-md-0">
                        <label class="font-weight-bold small">الأيقونة</label>
                        <input type="text" name="icon" class="form-control text-center" value="📁" maxlength="5">
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

    {{-- Subcategories list --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h6 class="mb-0 font-weight-bold">
                <i class="fas fa-folder text-warning mr-2"></i>
                التصنيفات الفرعية
                <span class="badge badge-secondary ml-2">{{ $subcategories->count() }}</span>
            </h6>
        </div>
        <div class="card-body p-0">
            @if($subcategories->count() > 0)
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th><th>الأيقونة</th><th>الاسم</th>
                            <th>عدد الملفات</th><th>الترتيب</th><th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subcategories as $i => $sub)
                        <tr>
                            <td class="text-muted">{{ $i + 1 }}</td>
                            <td style="font-size:22px">{{ $sub->icon }}</td>
                            <td>
                                <strong>{{ $sub->name_ar }}</strong>
                                @if($sub->name_en)
                                    <small class="text-muted d-block">{{ $sub->name_en }}</small>
                                @endif
                            </td>
                            <td><span class="badge badge-info">{{ $sub->files_count }} ملف</span></td>
                            <td class="text-muted">{{ $sub->sort_order }}</td>
                            <td>
                                <a href="{{ route('admin.pdf-bag.subcategories.show', $sub->id) }}"
                                   class="btn btn-sm btn-outline-primary mr-1">
                                    <i class="fas fa-folder-open"></i> إدارة الملفات
                                </a>
                                <form action="{{ route('admin.pdf-bag.subcategories.destroy', $sub->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('حذف التصنيف الفرعي وجميع ملفاته؟')">
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
            @else
                <div class="text-center py-5 text-muted">
                    <div style="font-size:48px">📂</div>
                    <p class="mt-3">لا توجد تصنيفات فرعية بعد.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection