{{-- resources/views/admin/quizzes/edit.blade.php --}}
@extends('layouts.admin')

@section('title', __('messages.edit_quiz'))

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.quizzes.index') }}"
           class="btn btn-sm btn-light border mr-3 qz-back-btn">
            <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} mr-1"></i>
            {{ __('messages.back_to_quizzes') }}
        </a>
        <div>
            <h4 class="mb-0 font-weight-bold">
                <span style="font-size:20px;margin-left:6px">✏️</span>
                {{ __('messages.edit_quiz') }}:
                <span class="text-primary">{{ $quiz->name }}</span>
            </h4>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Quick stats --}}
    <div class="row mb-4">
        <div class="col-sm-4 col-md-2">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-body py-3 text-center">
                    <div class="qz-stat-num text-primary">{{ $quiz->questions->count() }}</div>
                    <div class="qz-stat-label">{{ __('messages.questions_count') }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-2">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-body py-3 text-center">
                    <div class="qz-stat-num text-success">{{ $quiz->attempts->count() }}</div>
                    <div class="qz-stat-label">{{ __('messages.attempts_count') }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-3">
            <a href="{{ route('admin.quizzes.questions', $quiz->id) }}"
               class="card border-0 shadow-sm rounded-lg text-decoration-none qz-manage-card">
                <div class="card-body py-3 d-flex align-items-center gap-2" style="gap:10px">
                    <i class="fas fa-list-ul text-primary" style="font-size:20px"></i>
                    <div>
                        <div class="font-weight-600 text-dark">{{ __('messages.manage_questions') }}</div>
                        <small class="text-muted">{{ __('messages.add_question') }}</small>
                    </div>
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-muted mr-auto"></i>
                </div>
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.quizzes.update', $quiz->id) }}" id="editQuizForm">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-8">

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
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $quiz->name) }}"
                                   class="form-control qz-input @error('name') is-invalid @enderror"
                                   required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="qz-label">{{ __('messages.quiz_description') }}</label>
                            <textarea name="description"
                                      class="form-control qz-input"
                                      rows="3">{{ old('description', $quiz->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="qz-label">
                                        {{ __('messages.duration_minutes') }}
                                        <span class="qz-required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="duration_minutes"
                                               value="{{ old('duration_minutes', $quiz->duration_minutes) }}"
                                               class="form-control qz-input"
                                               min="1" max="180" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="qz-label">&nbsp;</label>
                                    <div class="qz-toggle-wrap" style="margin-top:6px">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   name="is_active"
                                                   id="isActive"
                                                   value="1"
                                                   {{ old('is_active', $quiz->is_active) ? 'checked' : '' }}>
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

                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header qz-card-header">
                        <i class="fas fa-layer-group mr-2 text-success"></i>
                        {{ __('messages.whatsapp_links') }}
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label class="qz-label">🏆 {{ __('messages.whatsapp_group_a') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text qz-wa-prepend"><i class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="url" name="whatsapp_a"
                                       value="{{ old('whatsapp_a', $quiz->whatsapp_a) }}"
                                       class="form-control qz-input @error('whatsapp_a') is-invalid @enderror"
                                       placeholder="{{ __('messages.whatsapp_link_hint') }}">
                                @if($quiz->whatsapp_a)
                                    <div class="input-group-append">
                                        <a href="{{ $quiz->whatsapp_a }}" target="_blank"
                                           class="btn btn-outline-success btn-sm"
                                           data-toggle="tooltip" title="{{ __('messages.view') }}">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                @endif
                                @error('whatsapp_a')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="qz-label">⭐ {{ __('messages.whatsapp_group_b') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text qz-wa-prepend"><i class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="url" name="whatsapp_b"
                                       value="{{ old('whatsapp_b', $quiz->whatsapp_b) }}"
                                       class="form-control qz-input @error('whatsapp_b') is-invalid @enderror"
                                       placeholder="{{ __('messages.whatsapp_link_hint') }}">
                                @if($quiz->whatsapp_b)
                                    <div class="input-group-append">
                                        <a href="{{ $quiz->whatsapp_b }}" target="_blank"
                                           class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                @endif
                                @error('whatsapp_b')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label class="qz-label">📚 {{ __('messages.whatsapp_group_c') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text qz-wa-prepend"><i class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="url" name="whatsapp_c"
                                       value="{{ old('whatsapp_c', $quiz->whatsapp_c) }}"
                                       class="form-control qz-input @error('whatsapp_c') is-invalid @enderror"
                                       placeholder="{{ __('messages.whatsapp_link_hint') }}">
                                @if($quiz->whatsapp_c)
                                    <div class="input-group-append">
                                        <a href="{{ $quiz->whatsapp_c }}" target="_blank"
                                           class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-md-4">
                {{-- Danger zone --}}
                <div class="card border-0 shadow-sm rounded-lg border-danger" style="border: 1px solid #f5c6cb !important;">
                    <div class="card-header" style="background:#fff5f5;border-bottom:1px solid #f5c6cb;font-weight:600;font-size:14px;color:#721c24;padding:14px 20px">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        {{ app()->getLocale() == 'ar' ? 'منطقة الخطر' : 'Danger Zone' }}
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-3">{{ __('messages.confirm_delete_quiz') }}</p>
                        <form method="POST"
                              action="{{ route('admin.quizzes.update', $quiz->id) }}"
                              onsubmit="return confirm('{{ __('messages.confirm_delete_quiz') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm btn-block">
                                <i class="fas fa-trash-alt mr-1"></i> {{ __('messages.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="qz-submit-bar">
            <a href="{{ route('admin.quizzes.index') }}" class="btn btn-light border px-4">
                {{ __('messages.cancel') }}
            </a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="fas fa-save mr-2"></i> {{ __('messages.save') }}
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
.qz-toggle-wrap { padding: 12px 16px; background: #f8f9fa; border-radius: 10px; border: 1px solid #e9ecef; }
.qz-wa-prepend { background: #25D366; color: white; border-color: #25D366; }
.qz-stat-num { font-size: 24px; font-weight: 700; line-height: 1; }
.qz-stat-label { font-size: 12px; color: #888; margin-top: 3px; }
.qz-manage-card:hover { background: #f8f9ff; border-color: #667eea !important; }
.font-weight-600 { font-weight: 600; }
.qz-submit-bar { display: flex; align-items: center; justify-content: flex-end; gap: 12px; padding: 20px 0; }
</style>
@endsection
