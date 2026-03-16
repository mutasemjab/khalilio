{{-- resources/views/admin/top-students/edit.blade.php --}}
@extends('layouts.admin')

@section('title', __('messages.edit_top_student'))

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
                <span style="font-size:20px;margin-left:6px">✏️</span>
                {{ __('messages.edit_top_student') }}:
                <span class="text-primary">{{ $topStudent->name }}</span>
            </h4>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.top-students.update', $topStudent->id) }}"
          enctype="multipart/form-data"
          id="editStudentForm">
        @csrf
        @method('PUT')

        <div class="row">

            {{-- ── Left: Info ── --}}
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header ts-card-header">
                        <i class="fas fa-user-graduate mr-2 text-primary"></i>
                        {{ __('messages.top_student_details') }}
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label class="ts-label">
                                {{ __('messages.student_name') }}
                                <span class="ts-required">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $topStudent->name) }}"
                                   class="form-control ts-input @error('name') is-invalid @enderror"
                                   required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="ts-label">{{ __('messages.school_name_label') }}</label>
                            <input type="text"
                                   name="school_name"
                                   value="{{ old('school_name', $topStudent->school_name) }}"
                                   class="form-control ts-input @error('school_name') is-invalid @enderror">
                            @error('school_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="ts-label">{{ __('messages.average_label') }}</label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="average"
                                               value="{{ old('average', $topStudent->average) }}"
                                               class="form-control ts-input @error('average') is-invalid @enderror"
                                               step="0.01" min="0" max="100">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="ts-label">{{ __('messages.rank_label') }}</label>
                                    <input type="text"
                                           name="rank"
                                           value="{{ old('rank', $topStudent->rank) }}"
                                           class="form-control ts-input"
                                           placeholder="{{ __('messages.rank_example') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="ts-label">{{ __('messages.display_order') }}</label>
                                    <input type="number"
                                           name="order"
                                           value="{{ old('order', $topStudent->order) }}"
                                           class="form-control ts-input"
                                           min="0">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="ts-toggle-wrap">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           name="is_active"
                                           id="isActive"
                                           value="1"
                                           {{ old('is_active', $topStudent->is_active) ? 'checked' : '' }}>
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

            {{-- ── Right: Photos ── --}}
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
                            <div class="ts-upload-zone" onclick="document.getElementById('inp_photo').click()">
                                @if($topStudent->photo)
                                    <img id="img_photo"
                                         src="{{ asset('assets/admin/uploads/' . $topStudent->photo) }}"
                                         alt="" class="ts-upload-img">
                                    <div class="ts-upload-preview d-none" id="prev_photo">
                                        <i class="fas fa-user-circle ts-upload-icon"></i>
                                    </div>
                                @else
                                    <div class="ts-upload-preview" id="prev_photo">
                                        <i class="fas fa-user-circle ts-upload-icon"></i>
                                        <span>{{ __('messages.upload_photo') }}</span>
                                        <small class="text-muted">{{ __('messages.photo_hint') }}</small>
                                    </div>
                                    <img id="img_photo" src="" alt="" class="ts-upload-img d-none">
                                @endif
                                @if($topStudent->photo)
                                    <div class="ts-photo-change-badge">{{ __('messages.change_photo') }}</div>
                                @endif
                            </div>
                            <input type="file" name="photo" id="inp_photo"
                                   class="d-none" accept="image/*"
                                   onchange="previewPhoto(this, 'img_photo', 'prev_photo')">
                            @error('photo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        {{-- Grades photo --}}
                        <div class="form-group ts-photo-group">
                            <label class="ts-label">
                                <span class="ts-photo-label-icon">📋</span>
                                {{ __('messages.grades_photo') }}
                            </label>
                            <div class="ts-upload-zone ts-upload-zone--sm" onclick="document.getElementById('inp_grades').click()">
                                @if($topStudent->grades_photo)
                                    <img id="img_grades"
                                         src="{{ asset('assets/admin/uploads/' . $topStudent->grades_photo) }}"
                                         alt="" class="ts-upload-img">
                                    <div class="ts-photo-change-badge">{{ __('messages.change_photo') }}</div>
                                @else
                                    <div class="ts-upload-preview" id="prev_grades">
                                        <i class="fas fa-file-alt ts-upload-icon"></i>
                                        <span>{{ __('messages.upload_photo') }}</span>
                                    </div>
                                    <img id="img_grades" src="" alt="" class="ts-upload-img d-none">
                                @endif
                            </div>
                            <input type="file" name="grades_photo" id="inp_grades"
                                   class="d-none" accept="image/*"
                                   onchange="previewPhoto(this, 'img_grades', 'prev_grades')">
                        </div>

                        {{-- Certificate photo --}}
                        <div class="form-group ts-photo-group mb-0">
                            <label class="ts-label">
                                <span class="ts-photo-label-icon">🏅</span>
                                {{ __('messages.certificate_photo') }}
                            </label>
                            <div class="ts-upload-zone ts-upload-zone--sm" onclick="document.getElementById('inp_cert').click()">
                                @if($topStudent->certificate_photo)
                                    <img id="img_cert"
                                         src="{{ asset('assets/admin/uploads/' . $topStudent->certificate_photo) }}"
                                         alt="" class="ts-upload-img">
                                    <div class="ts-photo-change-badge">{{ __('messages.change_photo') }}</div>
                                @else
                                    <div class="ts-upload-preview" id="prev_cert">
                                        <i class="fas fa-certificate ts-upload-icon"></i>
                                        <span>{{ __('messages.upload_photo') }}</span>
                                    </div>
                                    <img id="img_cert" src="" alt="" class="ts-upload-img d-none">
                                @endif
                            </div>
                            <input type="file" name="certificate_photo" id="inp_cert"
                                   class="d-none" accept="image/*"
                                   onchange="previewPhoto(this, 'img_cert', 'prev_cert')">
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- Submit bar --}}
        <div class="ts-submit-bar">
            <form method="POST"
                  action="{{ route('admin.top-students.destroy', $topStudent->id) }}"
                  style="margin:0"
                  onsubmit="return confirm('{{ __('messages.confirm_delete_student') }}')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger px-4">
                    <i class="fas fa-trash-alt mr-1"></i> {{ __('messages.delete') }}
                </button>
            </form>
            <div class="ml-auto d-flex gap-3" style="gap:12px">
                <a href="{{ route('admin.top-students.index') }}" class="btn btn-light border px-4">
                    {{ __('messages.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary px-5">
                    <i class="fas fa-save mr-2"></i> {{ __('messages.save') }}
                </button>
            </div>
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
.ts-photo-label-icon { font-size: 16px; margin-left: 6px; }
html[dir="ltr"] .ts-photo-label-icon { margin-left: 0; margin-right: 6px; }
.ts-upload-zone { border: 2px dashed #d0d0d0; border-radius: 12px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.25s ease; background: #fafafa; min-height: 110px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
.ts-upload-zone:hover { border-color: #667eea; background: rgba(102,126,234,0.04); }
.ts-upload-zone--sm { min-height: 80px; padding: 14px; }
.ts-upload-preview { display: flex; flex-direction: column; align-items: center; gap: 5px; pointer-events: none; }
.ts-upload-icon { font-size: 28px; color: #aaa; }
.ts-upload-zone--sm .ts-upload-icon { font-size: 20px; }
.ts-upload-preview span { font-size: 13px; font-weight: 500; color: #888; }
.ts-upload-img { width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; border-radius: 10px; }
.ts-photo-change-badge { position: absolute; bottom: 8px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.6); color: white; font-size: 11px; padding: 3px 10px; border-radius: 10px; white-space: nowrap; z-index: 2; opacity: 0; transition: opacity 0.2s ease; }
.ts-upload-zone:hover .ts-photo-change-badge { opacity: 1; }
.ts-submit-bar { display: flex; align-items: center; justify-content: space-between; padding: 20px 0; flex-wrap: wrap; gap: 12px; }
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
        if (img.classList.contains('d-none')) img.classList.remove('d-none');
        if (prev) prev.classList.add('d-none');
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
