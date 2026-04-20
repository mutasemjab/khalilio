{{-- resources/views/admin/bag-exams/index.blade.php --}}
@extends('layouts.admin')
@section('title', app()->getLocale() === 'ar' ? 'امتحانات: ' . $subcategory->name_ar : 'Exams: ' . ($subcategory->name_en ?: $subcategory->name_ar))

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap" style="gap:12px">
        <div>
            <a href="{{ route('admin.pdf-bag.subcategories.show', $subcategory->id) }}"
               class="btn btn-sm btn-outline-secondary mb-2">
                <i class="fas fa-arrow-right mr-1"></i>
                {{ app()->getLocale() === 'ar' ? 'العودة للتصنيف الفرعي' : 'Back to Subcategory' }}
            </a>
            <h4 class="mb-1 font-weight-bold">
                <span style="font-size:22px">📝</span>
                {{ app()->getLocale() === 'ar' ? 'امتحانات' : 'Exams' }}:
                {{ $subcategory->name_ar }}
            </h4>
            <p class="text-muted mb-0 small">
                {{ app()->getLocale() === 'ar' ? 'إدارة الامتحانات لهذا التصنيف الفرعي' : 'Manage exams for this subcategory' }}
            </p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-lg shadow-sm">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger border-0 rounded-lg shadow-sm">
        <ul class="mb-0 pl-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    {{-- ── Add Exam Form ──────────────────────────────────── --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: linear-gradient(135deg,#667eea,#764ba2); color:white;">
            <h6 class="mb-0 font-weight-bold">
                <i class="fas fa-plus-circle mr-2"></i>
                {{ app()->getLocale() === 'ar' ? 'إضافة امتحان جديد' : 'Add New Exam' }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.bag-exams.store', $subcategory->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small">
                            {{ app()->getLocale() === 'ar' ? 'عنوان الامتحان (عربي)' : 'Exam Title (Arabic)' }} *
                        </label>
                        <input type="text" name="title_ar" class="form-control" required
                               placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: امتحان الوحدة الأولى' : 'e.g. Unit 1 Exam' }}"
                               value="{{ old('title_ar') }}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small">
                            {{ app()->getLocale() === 'ar' ? 'عنوان الامتحان (إنجليزي)' : 'Exam Title (English)' }}
                        </label>
                        <input type="text" name="title_en" class="form-control"
                               placeholder="e.g. Unit 1 Exam"
                               value="{{ old('title_en') }}">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">
                            {{ app()->getLocale() === 'ar' ? 'المدة (دقيقة)' : 'Duration (min)' }} *
                        </label>
                        <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', 30) }}" min="1" max="300" required>
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">
                            {{ app()->getLocale() === 'ar' ? 'مجموع العلامات' : 'Total Marks' }} *
                        </label>
                        <input type="number" name="total_marks" class="form-control" value="{{ old('total_marks', 100) }}" min="1" max="1000" required>
                    </div>
                    <div class="col-md-5 form-group">
                        <label class="font-weight-bold small">
                            {{ app()->getLocale() === 'ar' ? 'وصف (عربي)' : 'Description (Arabic)' }}
                        </label>
                        <textarea name="description_ar" class="form-control" rows="2"
                                  placeholder="{{ app()->getLocale() === 'ar' ? 'وصف مختصر للامتحان...' : 'Short description...' }}">{{ old('description_ar') }}</textarea>
                    </div>
                    <div class="col-md-5 form-group">
                        <label class="font-weight-bold small">
                            {{ app()->getLocale() === 'ar' ? 'وصف (إنجليزي)' : 'Description (English)' }}
                        </label>
                        <textarea name="description_en" class="form-control" rows="2"
                                  placeholder="Short description...">{{ old('description_en') }}</textarea>
                    </div>
                    <div class="col-md-1 form-group">
                        <label class="font-weight-bold small">{{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Order' }}</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                    <div class="col-md-1 form-group d-flex align-items-end">
                        <div class="custom-control custom-switch mt-4">
                            <input type="checkbox" class="custom-control-input" id="is_active_new" name="is_active" value="1" checked>
                            <label class="custom-control-label font-weight-bold small" for="is_active_new">
                                {{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i>
                    {{ app()->getLocale() === 'ar' ? 'إضافة الامتحان' : 'Add Exam' }}
                </button>
            </form>
        </div>
    </div>

    {{-- ── Exams List ─────────────────────────────────────── --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h6 class="mb-0 font-weight-bold">
                <i class="fas fa-list mr-2 text-primary"></i>
                {{ app()->getLocale() === 'ar' ? 'الامتحانات' : 'Exams' }}
                <span class="badge badge-secondary ml-2">{{ $exams->count() }}</span>
            </h6>
        </div>
        <div class="card-body p-0">
            @if($exams->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'الامتحان' : 'Exam' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'الأسئلة' : 'Questions' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'العلامات' : 'Marks' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'المدة' : 'Duration' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'المحاولات' : 'Attempts' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'إجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exams as $i => $exam)
                        <tr>
                            <td class="text-muted">{{ $i + 1 }}</td>
                            <td>
                                <strong>{{ $exam->title_ar }}</strong>
                                @if($exam->title_en)
                                <small class="text-muted d-block">{{ $exam->title_en }}</small>
                                @endif
                                @if($exam->description_ar)
                                <small class="text-muted d-block" style="font-size:11px">{{ Str::limit($exam->description_ar, 60) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $exam->questions_count }}</span>
                            </td>
                            <td><span class="badge badge-warning">{{ $exam->total_marks }}</span></td>
                            <td><small>{{ $exam->duration_minutes }} {{ app()->getLocale() === 'ar' ? 'د' : 'min' }}</small></td>
                            <td>
                                <a href="{{ route('admin.bag-exams.attempts', $exam->id) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-users mr-1"></i>{{ $exam->attempts_count }}
                                </a>
                            </td>
                            <td>
                                @if($exam->is_active)
                                <span class="badge badge-success">{{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}</span>
                                @else
                                <span class="badge badge-secondary">{{ app()->getLocale() === 'ar' ? 'معطّل' : 'Inactive' }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.bag-exams.questions', $exam->id) }}"
                                   class="btn btn-sm btn-outline-primary mr-1"
                                   title="{{ app()->getLocale() === 'ar' ? 'الأسئلة' : 'Questions' }}">
                                    <i class="fas fa-question-circle"></i>
                                </a>

                                <button class="btn btn-sm btn-outline-secondary mr-1"
                                        data-toggle="collapse"
                                        data-target="#edit{{ $exam->id }}"
                                        title="{{ app()->getLocale() === 'ar' ? 'تعديل' : 'Edit' }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.bag-exams.destroy', $exam->id) }}"
                                      method="POST" class="d-inline" id="del-form-{{ $exam->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="beConfirmDelete('del-form-{{ $exam->id }}', '{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف الامتحان وكل بياناته؟' : 'Delete exam and all its data?' }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        {{-- Inline edit row --}}
                        <tr class="collapse bg-light" id="edit{{ $exam->id }}">
                            <td colspan="8" class="p-3">
                                <form action="{{ route('admin.bag-exams.update', $exam->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="row">
                                        <div class="col-md-3 form-group mb-2">
                                            <label class="small font-weight-bold">{{ app()->getLocale() === 'ar' ? 'العنوان (عربي)' : 'Title (AR)' }} *</label>
                                            <input type="text" name="title_ar" class="form-control form-control-sm"
                                                   value="{{ $exam->title_ar }}" required>
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                            <label class="small font-weight-bold">{{ app()->getLocale() === 'ar' ? 'العنوان (إنجليزي)' : 'Title (EN)' }}</label>
                                            <input type="text" name="title_en" class="form-control form-control-sm"
                                                   value="{{ $exam->title_en }}">
                                        </div>
                                        <div class="col-md-2 form-group mb-2">
                                            <label class="small font-weight-bold">{{ app()->getLocale() === 'ar' ? 'المدة (د)' : 'Duration' }}</label>
                                            <input type="number" name="duration_minutes" class="form-control form-control-sm"
                                                   value="{{ $exam->duration_minutes }}" min="1" max="300" required>
                                        </div>
                                        <div class="col-md-2 form-group mb-2">
                                            <label class="small font-weight-bold">{{ app()->getLocale() === 'ar' ? 'مجموع العلامات' : 'Total Marks' }}</label>
                                            <input type="number" name="total_marks" class="form-control form-control-sm"
                                                   value="{{ $exam->total_marks }}" min="1" max="1000" required>
                                        </div>
                                        <div class="col-md-1 form-group mb-2">
                                            <label class="small font-weight-bold">{{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Order' }}</label>
                                            <input type="number" name="sort_order" class="form-control form-control-sm"
                                                   value="{{ $exam->sort_order }}" min="0">
                                        </div>
                                        <div class="col-md-1 form-group mb-2 d-flex align-items-end">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="active{{ $exam->id }}" name="is_active" value="1"
                                                       {{ $exam->is_active ? 'checked' : '' }}>
                                                <label class="custom-control-label small" for="active{{ $exam->id }}">
                                                    {{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mb-2">
                                            <label class="small font-weight-bold">{{ app()->getLocale() === 'ar' ? 'الوصف (عربي)' : 'Description (AR)' }}</label>
                                            <textarea name="description_ar" class="form-control form-control-sm" rows="2">{{ $exam->description_ar }}</textarea>
                                        </div>
                                        <div class="col-md-6 form-group mb-2">
                                            <label class="small font-weight-bold">{{ app()->getLocale() === 'ar' ? 'الوصف (إنجليزي)' : 'Description (EN)' }}</label>
                                            <textarea name="description_en" class="form-control form-control-sm" rows="2">{{ $exam->description_en }}</textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-save mr-1"></i>
                                        {{ app()->getLocale() === 'ar' ? 'حفظ التعديلات' : 'Save Changes' }}
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
                <div style="font-size:48px">📝</div>
                <p class="mt-3">{{ app()->getLocale() === 'ar' ? 'لا توجد امتحانات بعد. أضف أول امتحان أعلاه.' : 'No exams yet. Add the first one above.' }}</p>
            </div>
            @endif
        </div>
    </div>

</div>

<script>
function beConfirmDelete(formId, msg) {
    if (window.confirm(msg)) {
        document.getElementById(formId).submit();
    }
}
</script>
@endsection
