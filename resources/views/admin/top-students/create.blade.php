{{-- resources/views/admin/top-students/create.blade.php --}}
@extends('layouts.admin')

@section('title', __('messages.add_top_student'))

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.top-students.index') }}"
           class="btn btn-sm btn-light border mr-3 ts-back-btn">
            <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} mr-1"></i>
            {{ __('messages.back_to_top_students') }}
        </a>
        <div>
            <h4 class="mb-0 font-weight-bold">
                <span style="font-size:20px;margin-left:6px">🏆</span>
                {{ __('messages.add_top_student') }}
            </h4>
        </div>
    </div>

    <form method="POST"
          action="{{ route('admin.top-students.store') }}"
          enctype="multipart/form-data"
          id="createStudentForm">
        @csrf

        <div class="row">

            {{-- ── Left column: Info ── --}}
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header ts-card-header">
                        <i class="fas fa-user-graduate mr-2 text-primary"></i>
                        {{ __('messages.top_student_details') }}
                    </div>
                    <div class="card-body">

                        {{-- Name --}}
                        <div class="form-group">
                            <label class="ts-label">
                                {{ __('messages.student_name') }}
                                <span class="ts-required">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control ts-input @error('name') is-invalid @enderror"
                                   placeholder="{{ __('messages.student_name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- School --}}
                        <div class="form-group">
                            <label class="ts-label">{{ __('messages.school_name_label') }}</label>
                            <input type="text"
                                   name="school_name"
                                   value="{{ old('school_name') }}"
                                   class="form-control ts-input @error('school_name') is-invalid @enderror"
                                   placeholder="{{ __('messages.school_name_label') }}">
                            @error('school_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Average --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="ts-label">{{ __('messages.average_label') }}</label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="average"
                                               value="{{ old('average') }}"
                                               class="form-control ts-input @error('average') is-invalid @enderror"
                                               step="0.01" min="0" max="100"
                                               placeholder="98.50">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    @error('average')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Rank --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="ts-label">{{ __('messages.rank_label') }}</label>
                                    <input type="text"
                                           name="rank"
                                           value="{{ old('rank') }}"
                                           class="form-control ts-input @error('rank') is-invalid @enderror"
                                           placeholder="{{ __('messages.rank_example') }}">
                                    @error('rank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Order --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="ts-label">{{ __('messages.display_order') }}</label>
                                    <input type="number"
                                           name="order"
                                           value="{{ old('order', 0) }}"
                                           class="form-control ts-input"
                                           min="0">
                                </div>
                            </div>
                        </div>

                        {{-- Status toggle --}}
                        <div class="form-group">
                            <div class="ts-toggle-wrap">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           name="is_active"
                                           id="isActive"
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label ts-label" for="isActive">
                                        {{ __('messages.is_active') }}
                                        <small class="text-muted d-block">{{ __('messages.is_active_desc') }}</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ── Right column: Photos ── --}}
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header ts-card-header">
                        <i class="fas fa-images mr-2 text-success"></i>
                        {{ __('messages.photos_section') }}
                    </div>
                    <div class="card-body">

                        {{-- Student photo --}}
                        <div class="form-group ts-photo-group">
                            <label class="ts-label">
                                <span class="ts-photo-label-icon">👤</span>
                                {{ __('messages.student_photo') }}
                            </label>
                            <div class="ts-upload-zone" id="zone_photo" onclick="document.getElementById('inp_photo').click()">
                                <div class="ts-upload-preview" id="prev_photo">
                                    <i class="fas fa-user-circle ts-upload-icon"></i>
                                    <span>{{ __('messages.upload_photo') }}</span>
                                    <small class="text-muted">{{ __('messages.photo_hint') }}</small>
                                </div>
                                <img id="img_photo" src="" alt="" class="ts-upload-img d-none">
                            </div>
                            <input type="file" name="photo" id="inp_photo"
                                   class="d-none" accept="image/*"
                                   onchange="previewPhoto(this, 'img_photo', 'prev_photo')">
                            @error('photo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Grades photo --}}
                        <div class="form-group ts-photo-group">
                            <label class="ts-label">
                                <span class="ts-photo-label-icon">📋</span>
                                {{ __('messages.grades_photo') }}
                            </label>
                            <div class="ts-upload-zone ts-upload-zone--sm" id="zone_grades" onclick="document.getElementById('inp_grades').click()">
                                <div class="ts-upload-preview" id="prev_grades">
                                    <i class="fas fa-file-alt ts-upload-icon"></i>
                                    <span>{{ __('messages.upload_photo') }}</span>
                                    <small class="text-muted">{{ __('messages.photo_hint') }}</small>
                                </div>
                                <img id="img_grades" src="" alt="" class="ts-upload-img d-none">
                            </div>
                            <input type="file" name="grades_photo" id="inp_grades"
                                   class="d-none" accept="image/*"
                                   onchange="previewPhoto(this, 'img_grades', 'prev_grades')">
                            @error('grades_photo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Certificate photo --}}
                        <div class="form-group ts-photo-group mb-0">
                            <label class="ts-label">
                                <span class="ts-photo-label-icon">🏅</span>
                                {{ __('messages.certificate_photo') }}
                            </label>
                            <div class="ts-upload-zone ts-upload-zone--sm" id="zone_cert" onclick="document.getElementById('inp_cert').click()">
                                <div class="ts-upload-preview" id="prev_cert">
                                    <i class="fas fa-certificate ts-upload-icon"></i>
                                    <span>{{ __('messages.upload_photo') }}</span>
                                    <small class="text-muted">{{ __('messages.photo_hint') }}</small>
                                </div>
                                <img id="img_cert" src="" alt="" class="ts-upload-img d-none">
                            </div>
                            <input type="file" name="certificate_photo" id="inp_cert"
                                   class="d-none" accept="image/*"
                                   onchange="previewPhoto(this, 'img_cert', 'prev_cert')">
                            @error('certificate_photo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- Submit bar --}}
        <div class="ts-submit-bar">
            <a href="{{ route('admin.top-students.index') }}"
               class="btn btn-light border px-4">
                {{ __('messages.cancel') }}
            </a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="fas fa-save mr-2"></i> {{ __('messages.save') }}
            </button>
        </div>

    </form>
</div>

<style>
.ts-back-btn { color: #495057; font-size: 13px; }
.ts-card-header { background: #f8f9fa; font-weight: 600; font-size: 14px; color: #495057; padding: 14px 20px; border-bottom: 1px solid #e9ecef; }
.ts-label { font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 7px; }
.ts-required { color: #dc3545; margin-right: 3px; }
.ts-input { border-radius: 10px; border-color: #e0e0e0; font-size: 14px; padding: 10px 14px; transition: all 0.2s ease; }
.ts-input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.12); }
.ts-toggle-wrap { padding: 14px; background: #f8f9fa; border-radius: 10px; border: 1px solid #e9ecef; }

/* Photo upload zones */
.ts-photo-label-icon { font-size: 16px; margin-left: 6px; }
html[dir="ltr"] .ts-photo-label-icon { margin-left: 0; margin-right: 6px; }
.ts-upload-zone {
    border: 2px dashed #d0d0d0; border-radius: 12px; padding: 20px;
    text-align: center; cursor: pointer; transition: all 0.25s ease;
    background: #fafafa; min-height: 110px;
    display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden;
}
.ts-upload-zone:hover { border-color: #667eea; background: rgba(102,126,234,0.04); }
.ts-upload-zone--sm { min-height: 80px; padding: 14px; }
.ts-upload-preview { display: flex; flex-direction: column; align-items: center; gap: 5px; pointer-events: none; }
.ts-upload-icon { font-size: 28px; color: #aaa; }
.ts-upload-zone--sm .ts-upload-icon { font-size: 20px; }
.ts-upload-preview span { font-size: 13px; font-weight: 500; color: #888; }
.ts-upload-preview small { font-size: 11px; }
.ts-upload-img { width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; border-radius: 10px; }

/* Submit bar */
.ts-submit-bar { display: flex; align-items: center; justify-content: flex-end; gap: 12px; padding: 20px 0; }
</style>

<script>
function previewPhoto(input, imgId, prevId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById(imgId);
        const prev = document.getElementById(prevId);
        img.src = e.target.result;
        img.classList.remove('d-none');
        prev.classList.add('d-none');
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
