{{-- resources/views/admin/quizzes/create.blade.php --}}
@extends('layouts.admin')

@section('title', __('messages.add_quiz'))

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.quizzes.index') }}"
           class="btn btn-sm btn-light border mr-3 qz-back-btn">
            <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} mr-1"></i>
            {{ __('messages.back_to_quizzes') }}
        </a>
        <h4 class="mb-0 font-weight-bold">
            <span style="font-size:20px;margin-left:6px">🧮</span>
            {{ __('messages.add_quiz') }}
        </h4>
    </div>

    <form method="POST" action="{{ route('admin.quizzes.store') }}" id="createQuizForm">
        @csrf

        <div class="row">
            <div class="col-md-8">

                {{-- Basic info --}}
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header qz-card-header">
                        <i class="fas fa-info-circle mr-2 text-primary"></i>
                        {{ __('messages.quiz_details') }}
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label class="qz-label">
                                {{ __('messages.quiz_name') }}
                                <span class="qz-required">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="form-control qz-input @error('name') is-invalid @enderror"
                                   placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: امتحان الرياضيات التشخيصي' : 'e.g.: Math Diagnostic Test' }}"
                                   required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="qz-label">{{ __('messages.quiz_description') }}</label>
                            <textarea name="description" class="form-control qz-input" rows="3"
                                      placeholder="{{ app()->getLocale() == 'ar' ? 'وصف مختصر...' : 'Brief description...' }}">{{ old('description') }}</textarea>
                        </div>

                        <div class="row">
                            {{-- Duration --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="qz-label">
                                        {{ __('messages.duration_minutes') }}
                                        <span class="qz-required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number" name="duration_minutes"
                                               value="{{ old('duration_minutes', 30) }}"
                                               class="form-control qz-input @error('duration_minutes') is-invalid @enderror"
                                               min="1" max="180" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                    </div>
                                    @error('duration_minutes')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Total marks ← NEW --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="qz-label">
                                        {{ app()->getLocale() == 'ar' ? 'العلامة الكاملة' : 'Total Marks' }}
                                        <span class="qz-required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number" name="total_marks"
                                               value="{{ old('total_marks', config('quiz.default_total_marks')) }}"
                                               class="form-control qz-input @error('total_marks') is-invalid @enderror"
                                               min="1" required
                                               id="totalMarksInput">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-star text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        {{ app()->getLocale() == 'ar'
                                            ? 'مجموع علامات الأسئلة يجب أن يساوي هذا الرقم'
                                            : 'Sum of all question grades must equal this' }}
                                    </small>
                                    @error('total_marks')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Active toggle --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="qz-label">&nbsp;</label>
                                    <div class="qz-toggle-wrap" style="margin-top:6px">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input"
                                                   name="is_active" id="isActive" value="1"
                                                   {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label qz-label" for="isActive">
                                                {{ __('messages.quiz_active') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- WhatsApp links --}}
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header qz-card-header">
                        <i class="fas fa-layer-group mr-2 text-success"></i>
                        {{ __('messages.whatsapp_links') }}
                    </div>
                    <div class="card-body">
                        <div class="qz-groups-row mb-4">
                            <div class="qz-group-info qz-group-info--a">
                                <div class="qz-group-emoji">🏆</div>
                                <div><div class="font-weight-600">{{ __('messages.group_a') }}</div><small>{{ __('messages.group_a_range') }}</small></div>
                            </div>
                            <div class="qz-group-info qz-group-info--b">
                                <div class="qz-group-emoji">⭐</div>
                                <div><div class="font-weight-600">{{ __('messages.group_b') }}</div><small>{{ __('messages.group_b_range') }}</small></div>
                            </div>
                            <div class="qz-group-info qz-group-info--c">
                                <div class="qz-group-emoji">📚</div>
                                <div><div class="font-weight-600">{{ __('messages.group_c') }}</div><small>{{ __('messages.group_c_range') }}</small></div>
                            </div>
                        </div>

                        @foreach(['a'=>'🏆','b'=>'⭐','c'=>'📚'] as $group => $emoji)
                        <div class="form-group {{ $group == 'c' ? 'mb-0' : '' }}">
                            <label class="qz-label">{{ $emoji }} {{ __('messages.whatsapp_group_' . $group) }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text qz-wa-prepend"><i class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="url" name="whatsapp_{{ $group }}"
                                       value="{{ old('whatsapp_' . $group) }}"
                                       class="form-control qz-input"
                                       placeholder="{{ __('messages.whatsapp_link_hint') }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Tips sidebar --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-lg qz-tips-card">
                    <div class="card-body">
                        <h6 class="font-weight-bold mb-3">
                            <i class="fas fa-lightbulb text-warning mr-2"></i>
                            {{ app()->getLocale() == 'ar' ? 'نصائح' : 'Tips' }}
                        </h6>
                        <ul class="qz-tips-list">
                            <li>{{ app()->getLocale() == 'ar' ? 'حدد العلامة الكاملة أولاً ثم وزّع علامات الأسئلة عليها.' : 'Set the total marks first, then distribute question grades.' }}</li>
                            <li>{{ app()->getLocale() == 'ar' ? 'مثال: امتحان 30 علامة → 10 أسئلة كل واحد 3 علامات.' : 'Example: 30-mark quiz → 10 questions × 3 marks each.' }}</li>
                            <li>{{ app()->getLocale() == 'ar' ? 'النظام يمنعك من إضافة سؤال علاماته أكثر من المتبقي.' : 'The system prevents adding a question whose grade exceeds remaining marks.' }}</li>
                            <li>{{ app()->getLocale() == 'ar' ? 'المجموعة أ: ≥83% | ب: ≥60% | ج: أقل من 60%.' : 'Group A: ≥83% | B: ≥60% | C: below 60%.' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="qz-submit-bar">
            <a href="{{ route('admin.quizzes.index') }}" class="btn btn-light border px-4">
                {{ __('messages.cancel') }}
            </a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} mr-2"></i>
                {{ __('messages.save_and_add_questions') }}
            </button>
        </div>
    </form>
</div>

<style>
.qz-back-btn { color: #495057; font-size: 13px; }
.qz-card-header { background: #f8f9fa; font-weight: 600; font-size: 14px; color: #495057; padding: 14px 20px; border-bottom: 1px solid #e9ecef; }
.qz-label { font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 7px; display: block; }
.qz-required { color: #dc3545; }
.qz-input { border-radius: 10px; border-color: #e0e0e0; font-size: 14px; padding: 10px 14px; transition: all 0.2s ease; }
.qz-input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.12); }
textarea.qz-input { border-radius: 10px; }
.qz-toggle-wrap { padding: 12px 16px; background: #f8f9fa; border-radius: 10px; border: 1px solid #e9ecef; }
.qz-wa-prepend { background: #25D366; color: white; border-color: #25D366; }
.qz-groups-row { display: flex; gap: 10px; }
.qz-group-info { flex: 1; display: flex; align-items: center; gap: 10px; padding: 10px; border-radius: 10px; font-size: 13px; }
.qz-group-info--a { background: rgba(247,151,30,0.1); color: #c07800; }
.qz-group-info--b { background: rgba(79,172,254,0.1); color: #2980b9; }
.qz-group-info--c { background: rgba(67,233,123,0.1); color: #0ba360; }
.qz-group-emoji { font-size: 18px; flex-shrink: 0; }
.font-weight-600 { font-weight: 600; }
.qz-tips-card { background: linear-gradient(135deg, #f8f9ff, #fff); border: 1px solid #e9ecef !important; }
.qz-tips-list { padding-right: 18px; margin: 0; }
html[dir="ltr"] .qz-tips-list { padding-right: 0; padding-left: 18px; }
.qz-tips-list li { font-size: 13px; color: #555; margin-bottom: 10px; line-height: 1.5; }
.qz-submit-bar { display: flex; align-items: center; justify-content: flex-end; gap: 12px; padding: 20px 0; }
</style>
@endsection
