{{-- resources/views/admin/bag-exams/attempts.blade.php --}}
@extends('layouts.admin')
@section('title', (app()->getLocale() === 'ar' ? 'محاولات: ' : 'Attempts: ') . $exam->title_ar)

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap" style="gap:12px">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.bag-exams.questions', $exam->id) }}"
               class="btn btn-sm btn-light border mr-3">
                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} mr-1"></i>
                {{ app()->getLocale() === 'ar' ? 'العودة للأسئلة' : 'Back to Questions' }}
            </a>
            <div>
                <h4 class="mb-0 font-weight-bold">
                    👥 {{ app()->getLocale() === 'ar' ? 'محاولات الطلاب' : 'Student Attempts' }}
                </h4>
                <p class="text-muted small mb-0">{{ $exam->title_ar }}</p>
            </div>
        </div>
        <span class="badge badge-secondary" style="font-size:14px; padding:8px 14px">
            {{ $attempts->total() }} {{ app()->getLocale() === 'ar' ? 'محاولة' : 'attempts' }}
        </span>
    </div>

    {{-- Search --}}
    <form method="GET" class="mb-3">
        <div class="input-group" style="max-width:400px">
            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                   placeholder="{{ app()->getLocale() === 'ar' ? 'بحث باسم الطالب أو الهاتف...' : 'Search by name or phone...' }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            @if($attempts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'الطالب' : 'Student' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'الهاتف' : 'Phone' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'النتيجة' : 'Score' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'النسبة' : 'Percentage' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'الأسئلة' : 'Questions' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'التاريخ' : 'Date' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attempts as $i => $attempt)
                        @php $pct = $attempt->total_marks > 0 ? round($attempt->score / $attempt->total_marks * 100) : 0; @endphp
                        <tr>
                            <td class="text-muted">{{ $attempts->firstItem() + $i }}</td>
                            <td><strong>{{ $attempt->student_name }}</strong></td>
                            <td class="text-muted">{{ $attempt->student_phone ?? '—' }}</td>
                            <td>
                                <span class="font-weight-bold {{ $pct >= 50 ? 'text-success' : 'text-danger' }}">
                                    {{ $attempt->score }}
                                </span>
                                <span class="text-muted">/ {{ $attempt->total_marks }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center" style="gap:8px">
                                    <div style="width:60px; height:8px; background:#eee; border-radius:4px; overflow:hidden">
                                        <div style="width:{{ $pct }}%; height:100%; background:{{ $pct >= 50 ? '#28a745' : '#dc3545' }}; border-radius:4px;"></div>
                                    </div>
                                    <span class="small font-weight-bold {{ $pct >= 50 ? 'text-success' : 'text-danger' }}">
                                        {{ $pct }}%
                                    </span>
                                </div>
                            </td>
                            <td class="text-muted">{{ $attempt->total_questions }}</td>
                            <td class="text-muted small">{{ $attempt->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-2">
                {{ $attempts->withQueryString()->links() }}
            </div>
            @else
            <div class="text-center py-5 text-muted">
                <div style="font-size:48px">👥</div>
                <p class="mt-3">{{ app()->getLocale() === 'ar' ? 'لا توجد محاولات بعد.' : 'No attempts yet.' }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
