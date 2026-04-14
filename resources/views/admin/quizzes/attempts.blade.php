{{-- resources/views/admin/quizzes/attempts.blade.php --}}
@extends('layouts.admin')

@section('title', __('messages.quiz_attempts') ?? 'مشاركو الاختبار')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('admin.quizzes.index') }}" class="btn btn-light btn-sm mb-2">
                <i class="fas fa-arrow-right mr-1"></i> {{ __('messages.back') ?? 'رجوع' }}
            </a>
            <h4 class="mb-1 font-weight-bold">
                <span style="font-size:20px;vertical-align:middle">📋</span>
                {{ $quiz->name }}
            </h4>
            <p class="text-muted mb-0 small">
                {{ __('messages.quiz_attempts') ?? 'الطلاب الذين أجروا الاختبار' }}
                &mdash;
                <strong>{{ $attempts->total() }}</strong> {{ __('messages.attempts_count') ?? 'محاولة' }}
            </p>
        </div>
        <div class="text-right">
            <div class="d-flex" style="gap:8px">
                <div class="at-stat-card" style="background:rgba(102,126,234,0.1);border-color:rgba(102,126,234,0.2)">
                    <div class="at-stat-val text-primary">{{ $attempts->total() }}</div>
                    <div class="at-stat-lbl">{{ __('messages.total') ?? 'الكل' }}</div>
                </div>
                <div class="at-stat-card" style="background:rgba(40,167,69,0.1);border-color:rgba(40,167,69,0.2)">
                    <div class="at-stat-val text-success">{{ $quiz->attempts()->where('group','A')->count() }}</div>
                    <div class="at-stat-lbl">المجموعة A</div>
                </div>
                <div class="at-stat-card" style="background:rgba(255,193,7,0.1);border-color:rgba(255,193,7,0.2)">
                    <div class="at-stat-val text-warning">{{ $quiz->attempts()->where('group','B')->count() }}</div>
                    <div class="at-stat-lbl">المجموعة B</div>
                </div>
                <div class="at-stat-card" style="background:rgba(220,53,69,0.1);border-color:rgba(220,53,69,0.2)">
                    <div class="at-stat-val text-danger">{{ $quiz->attempts()->where('group','C')->count() }}</div>
                    <div class="at-stat-lbl">المجموعة C</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.quizzes.attempts', $quiz->id) }}" class="form-inline flex-wrap" style="gap:10px">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control form-control-sm"
                       placeholder="{{ __('messages.Name') ?? 'اسم' }} / {{ __('messages.Phone') ?? 'هاتف' }}"
                       style="min-width:220px">

                <select name="group" class="form-control form-control-sm">
                    <option value="">-- {{ __('messages.group') ?? 'المجموعة' }} --</option>
                    <option value="A" {{ request('group') == 'A' ? 'selected' : '' }}>A (> 42)</option>
                    <option value="B" {{ request('group') == 'B' ? 'selected' : '' }}>B (30–42)</option>
                    <option value="C" {{ request('group') == 'C' ? 'selected' : '' }}>C (< 30)</option>
                </select>

                <button type="submit" class="btn btn-primary btn-sm px-4">
                    <i class="fas fa-filter mr-1"></i> {{ __('messages.filter') ?? 'فلتر' }}
                </button>
                @if(request()->hasAny(['search','group']))
                    <a href="{{ route('admin.quizzes.attempts', $quiz->id) }}" class="btn btn-light btn-sm px-3">
                        <i class="fas fa-times mr-1"></i> {{ __('messages.clear') ?? 'مسح' }}
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm rounded-lg">
        <div class="card-body p-0">
            @if($attempts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 at-table">
                    <thead>
                        <tr>
                            <th class="pl-4">#</th>
                            <th>{{ __('messages.Name') ?? 'الاسم' }}</th>
                            <th>{{ __('messages.Phone') ?? 'الهاتف' }}</th>
                            <th>{{ __('messages.score') ?? 'الدرجة' }}</th>
                            <th>{{ __('messages.total_marks') ?? 'من' }}</th>
                            <th>{{ __('messages.percentage') ?? 'النسبة' }}</th>
                            <th>{{ __('messages.group') ?? 'المجموعة' }}</th>
                            <th>{{ __('messages.questions_count') ?? 'عدد الأسئلة' }}</th>
                            <th>{{ __('messages.created_at') ?? 'تاريخ التقديم' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attempts as $attempt)
                        <tr>
                            <td class="pl-4 text-muted small">{{ $attempt->id }}</td>
                            <td class="font-weight-600">{{ $attempt->student_name }}</td>
                            <td class="text-muted">{{ $attempt->student_phone ?? '—' }}</td>
                            <td>
                                <strong class="
                                    @if($attempt->group === 'A') text-success
                                    @elseif($attempt->group === 'B') text-warning
                                    @else text-danger
                                    @endif
                                ">{{ $attempt->score }}</strong>
                            </td>
                            <td class="text-muted">{{ $attempt->total_marks }}</td>
                            <td>
                                @php $pct = $attempt->total_marks > 0 ? round(($attempt->score / $attempt->total_marks) * 100) : 0; @endphp
                                <div class="d-flex align-items-center" style="gap:6px;min-width:100px">
                                    <div class="at-bar-wrap">
                                        <div class="at-bar-fill
                                            @if($pct >= 70) at-bar-a
                                            @elseif($pct >= 50) at-bar-b
                                            @else at-bar-c
                                            @endif
                                        " style="width:{{ $pct }}%"></div>
                                    </div>
                                    <span class="small text-muted">{{ $pct }}%</span>
                                </div>
                            </td>
                            <td>
                                @if($attempt->group === 'A')
                                    <span class="at-group-badge at-group-a">A</span>
                                @elseif($attempt->group === 'B')
                                    <span class="at-group-badge at-group-b">B</span>
                                @else
                                    <span class="at-group-badge at-group-c">C</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $attempt->total_questions }}</td>
                            <td class="text-muted small">{{ $attempt->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center py-3">
                {{ $attempts->links() }}
            </div>

            @else
            <div class="text-center py-5">
                <div style="font-size:56px;margin-bottom:16px">📭</div>
                <h5 class="text-muted font-weight-600">{{ __('messages.no_attempts') ?? 'لا توجد محاولات بعد' }}</h5>
                <p class="text-muted small">{{ __('messages.no_attempts_desc') ?? 'لم يُقدِّم أحد هذا الاختبار بعد' }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.at-stat-card { border:1px solid #eee; border-radius:12px; padding:10px 18px; text-align:center; min-width:80px; }
.at-stat-val  { font-size:22px; font-weight:700; }
.at-stat-lbl  { font-size:11px; color:#6c757d; margin-top:2px; }

.at-table thead th { background:#f8f9fa; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:.5px; color:#6c757d; border-bottom:2px solid #e9ecef; padding:14px 12px; white-space:nowrap; }
.at-table tbody td { vertical-align:middle; padding:12px 12px; border-color:#f0f0f0; }
.font-weight-600 { font-weight:600; }

.at-bar-wrap  { width:80px; height:8px; background:#eee; border-radius:4px; overflow:hidden; }
.at-bar-fill  { height:100%; border-radius:4px; }
.at-bar-a     { background:#28a745; }
.at-bar-b     { background:#ffc107; }
.at-bar-c     { background:#dc3545; }

.at-group-badge { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:50%; font-size:12px; font-weight:700; }
.at-group-a { background:rgba(40,167,69,0.15); color:#1a7a34; }
.at-group-b { background:rgba(255,193,7,0.2); color:#856404; }
.at-group-c { background:rgba(220,53,69,0.12); color:#c82333; }
</style>
@endsection
