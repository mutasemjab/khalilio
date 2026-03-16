{{-- resources/views/admin/top-students/index.blade.php --}}
@extends('layouts.admin')

@section('title', __('messages.top_students'))

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 font-weight-bold">
                <span class="ts-icon-badge">🏆</span>
                {{ __('messages.top_students') }}
            </h4>
            <p class="text-muted mb-0 small">{{ __('messages.top_students_list') }}</p>
        </div>
        <a href="{{ route('admin.top-students.create') }}" class="btn btn-primary btn-sm px-4">
            <i class="fas fa-plus mr-1"></i> {{ __('messages.add_top_student') }}
        </a>
    </div>



    {{-- Stats row --}}
    <div class="row mb-4">
        <div class="col-sm-4 col-md-3">
            <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                <div class="card-body py-3 d-flex align-items-center gap-3">
                    <div class="ts-stat-icon ts-stat-icon--total">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <div class="ts-stat-num">{{ $students->count() }}</div>
                        <div class="ts-stat-label">{{ __('messages.students_count') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-3">
            <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                <div class="card-body py-3 d-flex align-items-center gap-3">
                    <div class="ts-stat-icon ts-stat-icon--active">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div>
                        <div class="ts-stat-num">{{ $students->where('is_active', true)->count() }}</div>
                        <div class="ts-stat-label">{{ __('messages.active_count') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-body p-0">
                    @if($students->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 ts-table">
                            <thead>
                                <tr>
                                    <th class="pl-4">{{ __('messages.ID') }}</th>
                                    <th>{{ __('messages.student_name') }}</th>
                                    <th>{{ __('messages.school_name_label') }}</th>
                                    <th>{{ __('messages.rank_label') }}</th>
                                    <th>{{ __('messages.average_label') }}</th>
                                    <th>{{ __('messages.photos_section') }}</th>
                                    <th>{{ __('messages.display_order') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                    <th>{{ __('messages.created_at') }}</th>
                                    <th class="text-center">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr class="ts-row">
                                    <td class="pl-4 text-muted small">{{ $student->id }}</td>

                                    {{-- Name + photo --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="ts-avatar">
                                                @if($student->photo)
                                                    <img src="{{ asset('assets/admin/uploads/' . $student->photo) }}"
                                                         alt="{{ $student->name }}"
                                                         class="ts-avatar-img"
                                                         data-toggle="tooltip"
                                                         title="{{ __('messages.student_photo') }}">
                                                @else
                                                    <div class="ts-avatar-placeholder">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-weight-600">{{ $student->name }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{ $student->school_name ?? '—' }}</td>

                                    {{-- Rank --}}
                                    <td>
                                        @if($student->rank)
                                            @php
                                                $rankIcon = match((string)$student->rank) {
                                                    '1','الأول','First'  => '🥇',
                                                    '2','الثاني','Second' => '🥈',
                                                    '3','الثالث','Third'  => '🥉',
                                                    default => '🏅',
                                                };
                                            @endphp
                                            <span class="ts-rank-badge">{{ $rankIcon }} {{ $student->rank }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- Average --}}
                                    <td>
                                        @if($student->average)
                                            <strong class="text-success">{{ number_format($student->average, 2) }}%</strong>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- Photos count --}}
                                    <td>
                                        <div class="ts-photos-status">
                                            <span class="ts-photo-dot {{ $student->photo ? 'filled' : '' }}"
                                                  data-toggle="tooltip" title="{{ __('messages.student_photo') }}">
                                                <i class="fas fa-user-circle"></i>
                                            </span>
                                            <span class="ts-photo-dot {{ $student->grades_photo ? 'filled' : '' }}"
                                                  data-toggle="tooltip" title="{{ __('messages.grades_photo') }}">
                                                <i class="fas fa-file-alt"></i>
                                            </span>
                                            <span class="ts-photo-dot {{ $student->certificate_photo ? 'filled' : '' }}"
                                                  data-toggle="tooltip" title="{{ __('messages.certificate_photo') }}">
                                                <i class="fas fa-certificate"></i>
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge badge-light border">{{ $student->order }}</span>
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        @if($student->is_active)
                                            <span class="badge ts-badge-active">
                                                <i class="fas fa-circle mr-1" style="font-size:7px;vertical-align:middle"></i>
                                                {{ __('messages.visible') }}
                                            </span>
                                        @else
                                            <span class="badge ts-badge-inactive">
                                                <i class="fas fa-circle mr-1" style="font-size:7px;vertical-align:middle"></i>
                                                {{ __('messages.hidden') }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-muted small">
                                        {{ $student->created_at->format('Y-m-d') }}
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <div class="ts-actions">
                                            <a href="{{ route('admin.top-students.edit', $student->id) }}"
                                               class="btn btn-sm ts-btn-edit"
                                               data-toggle="tooltip" title="{{ __('messages.edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('admin.top-students.destroy', $student->id) }}"
                                                  style="display:inline"
                                                  onsubmit="return confirm('{{ __('messages.confirm_delete_student') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm ts-btn-delete"
                                                        data-toggle="tooltip" title="{{ __('messages.delete') }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if(method_exists($students, 'links'))
                    <div class="d-flex justify-content-center py-3">
                        {{ $students->links() }}
                    </div>
                    @endif

                    @else
                    {{-- Empty state --}}
                    <div class="ts-empty-state">
                        <div class="ts-empty-icon">🏆</div>
                        <h5>{{ __('messages.no_top_students') }}</h5>
                        <p class="text-muted">{{ __('messages.no_top_students_desc') }}</p>
                        <a href="{{ route('admin.top-students.create') }}" class="btn btn-primary btn-sm px-4">
                            <i class="fas fa-plus mr-1"></i> {{ __('messages.add_top_student') }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ── Page ──────────────────────────────────────────────────── */
.ts-icon-badge { font-size: 22px; margin-left: 6px; vertical-align: middle; }

/* ── Stats ─────────────────────────────────────────────────── */
.ts-stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; margin-left: 14px; }
html[dir="ltr"] .ts-stat-icon { margin-left: 0; margin-right: 14px; }
.ts-stat-icon--total { background: rgba(102,126,234,0.12); color: #667eea; }
.ts-stat-icon--active { background: rgba(40,167,69,0.12); color: #28a745; }
.ts-stat-num { font-size: 22px; font-weight: 700; line-height: 1; color: #222; }
.ts-stat-label { font-size: 12px; color: #888; margin-top: 2px; }

/* ── Table ─────────────────────────────────────────────────── */
.ts-table thead th { background: #f8f9fa; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; border-bottom: 2px solid #e9ecef; padding: 14px 12px; white-space: nowrap; }
.ts-table tbody td { vertical-align: middle; padding: 12px 12px; border-color: #f0f0f0; }
.ts-row { transition: background 0.15s ease; }
.ts-row:hover { background: #fafbff !important; }

/* Avatar */
.ts-avatar { flex-shrink: 0; }
.ts-avatar-img { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #e9ecef; }
.ts-avatar-placeholder { width: 38px; height: 38px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 16px; }
.font-weight-600 { font-weight: 600; }

/* Rank badge */
.ts-rank-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; background: rgba(247,151,30,0.12); color: #c07800; border-radius: 20px; font-size: 13px; font-weight: 600; }

/* Photos status dots */
.ts-photos-status { display: flex; gap: 6px; align-items: center; }
.ts-photo-dot { width: 24px; height: 24px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 11px; color: #bbb; transition: all 0.2s ease; cursor: default; }
.ts-photo-dot.filled { background: rgba(40,167,69,0.15); color: #28a745; }

/* Status badges */
.ts-badge-active { background: rgba(40,167,69,0.12); color: #1a7a34; font-size: 12px; padding: 5px 10px; border-radius: 20px; }
.ts-badge-inactive { background: rgba(108,117,125,0.12); color: #5a6268; font-size: 12px; padding: 5px 10px; border-radius: 20px; }

/* Action buttons */
.ts-actions { display: flex; gap: 6px; justify-content: center; }
.ts-btn-edit { background: rgba(255,193,7,0.12); color: #d39e00; border: 1px solid rgba(255,193,7,0.25); border-radius: 8px; padding: 5px 10px; transition: all 0.2s ease; }
.ts-btn-edit:hover { background: #ffc107; color: white; border-color: #ffc107; }
.ts-btn-delete { background: rgba(220,53,69,0.1); color: #dc3545; border: 1px solid rgba(220,53,69,0.2); border-radius: 8px; padding: 5px 10px; transition: all 0.2s ease; }
.ts-btn-delete:hover { background: #dc3545; color: white; border-color: #dc3545; }

/* Empty state */
.ts-empty-state { text-align: center; padding: 60px 20px; }
.ts-empty-icon { font-size: 56px; margin-bottom: 16px; display: block; }
.ts-empty-state h5 { font-weight: 600; color: #495057; margin-bottom: 8px; }
</style>

<script>
$(function() { $('[data-toggle="tooltip"]').tooltip(); });
</script>
@endsection
