{{-- resources/views/admin/bag-exams/questions.blade.php --}}
@extends('layouts.admin')
@section('title', (app()->getLocale() === 'ar' ? 'أسئلة: ' : 'Questions: ') . $exam->title_ar)

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap" style="gap:12px">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.bag-exams.index', $exam->subcategory->id) }}"
               class="btn btn-sm btn-light border mr-3">
                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} mr-1"></i>
                {{ app()->getLocale() === 'ar' ? 'العودة للامتحانات' : 'Back to Exams' }}
            </a>
            <div>
                <h4 class="mb-0 font-weight-bold">❓ {{ app()->getLocale() === 'ar' ? 'الأسئلة' : 'Questions' }}</h4>
                <p class="text-muted small mb-0">{{ $exam->title_ar }}</p>
            </div>
        </div>
        <a href="{{ route('admin.bag-exams.attempts', $exam->id) }}" class="btn btn-sm btn-light border">
            <i class="fas fa-users mr-1"></i>
            {{ app()->getLocale() === 'ar' ? 'المحاولات' : 'Attempts' }}
            <span class="badge badge-secondary ml-1">{{ $exam->attempts()->count() }}</span>
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    {{-- Marks panel --}}
    <div class="qq-marks-panel {{ $isComplete ? 'qq-marks-panel--complete' : ($currentSum > $exam->total_marks ? 'qq-marks-panel--over' : '') }}">
        <div class="qq-marks-header">
            <div class="qq-marks-label">
                <i class="fas fa-star mr-1"></i>
                {{ app()->getLocale() == 'ar' ? 'توزيع العلامات' : 'Marks Distribution' }}
            </div>
            <div class="qq-marks-numbers">
                <span class="qq-marks-used">{{ $currentSum }}</span>
                <span class="qq-marks-sep">/</span>
                <span class="qq-marks-total">{{ $exam->total_marks }}</span>
                @if($isComplete)
                    <span class="qq-marks-complete-badge"><i class="fas fa-check-circle mr-1"></i>{{ app()->getLocale() == 'ar' ? 'مكتمل' : 'Complete' }}</span>
                @elseif($remainingMarks > 0)
                    <span class="qq-marks-remaining-badge">{{ app()->getLocale() == 'ar' ? "متبقي: {$remainingMarks}" : "Remaining: {$remainingMarks}" }}</span>
                @else
                    <span class="qq-marks-over-badge"><i class="fas fa-exclamation-triangle mr-1"></i>{{ app()->getLocale() == 'ar' ? 'تجاوز الحد' : 'Over limit' }}</span>
                @endif
            </div>
        </div>
        <div class="qq-marks-bar-wrap">
            @php $pct = $exam->total_marks > 0 ? min(100, round(($currentSum / $exam->total_marks) * 100)) : 0; @endphp
            <div class="qq-marks-bar"><div class="qq-marks-bar-fill" style="width:{{ $pct }}%"></div></div>
            <span class="qq-marks-pct">{{ $pct }}%</span>
        </div>
        @if($questions->count() > 0)
        <div class="qq-marks-chips">
            @foreach($questions as $i => $q)
            <div class="qq-marks-chip" title="{{ $q->question_text }}">
                <span class="qq-chip-num">س{{ $i+1 }}</span>
                <span class="qq-chip-grade">{{ $q->grade }}{{ app()->getLocale() == 'ar' ? 'ع' : 'pt' }}</span>
            </div>
            @endforeach
            @if($remainingMarks > 0)
            <div class="qq-marks-chip qq-marks-chip--empty">
                <span class="qq-chip-num">...</span>
                <span class="qq-chip-grade">{{ $remainingMarks }}{{ app()->getLocale() == 'ar' ? 'ع' : 'pt' }}</span>
            </div>
            @endif
        </div>
        @endif
    </div>

    <div class="row">
        {{-- Add question form --}}
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm rounded-lg qq-add-card">
                <div class="card-header qq-card-header">
                    <i class="fas fa-plus-circle mr-2 text-primary"></i>
                    {{ app()->getLocale() === 'ar' ? 'إضافة سؤال' : 'Add Question' }}
                    @if($isComplete)
                    <span class="badge badge-warning mr-2" style="font-size:11px">
                        {{ app()->getLocale() == 'ar' ? 'العلامات مكتملة' : 'Marks Full' }}
                    </span>
                    @endif
                </div>
                <div class="card-body">
                    @if($isComplete)
                    <div class="alert alert-warning border-0 rounded-lg py-2 mb-3" style="font-size:13px">
                        <i class="fas fa-lock mr-1"></i>
                        {{ app()->getLocale() == 'ar'
                            ? "مجموع العلامات ({$exam->total_marks}) مكتمل."
                            : "Total marks ({$exam->total_marks}) fully assigned." }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger border-0 py-2 mb-3" style="font-size:13px">
                        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.bag-exams.questions.store', $exam->id) }}"
                          enctype="multipart/form-data" id="addQuestionForm">
                        @csrf

                        <div class="form-group">
                            <label class="qq-label">{{ app()->getLocale() === 'ar' ? 'نص السؤال' : 'Question Text' }} <span class="qq-required">*</span></label>
                            <textarea name="question_text" class="form-control qq-input" rows="3"
                                      placeholder="{{ app()->getLocale() == 'ar' ? 'اكتب السؤال هنا...' : 'Write the question here...' }}"
                                      required>{{ old('question_text') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="qq-label">
                                <i class="fas fa-star text-warning mr-1"></i>
                                {{ app()->getLocale() === 'ar' ? 'علامة السؤال' : 'Question Grade' }} <span class="qq-required">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" name="grade" id="gradeInput"
                                       value="{{ old('grade', $remainingMarks > 0 ? min(1, $remainingMarks) : 1) }}"
                                       class="form-control qq-input qq-grade-input"
                                       min="1" max="{{ $exam->total_marks }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text qq-grade-suffix">
                                        {{ app()->getLocale() == 'ar' ? 'من' : 'of' }}
                                        <strong class="mx-1" id="remainingDisplay">{{ $remainingMarks }}</strong>
                                        {{ app()->getLocale() == 'ar' ? 'متبقي' : 'rem.' }}
                                    </span>
                                </div>
                            </div>
                            <div class="qq-quick-grades mt-2">
                                @foreach([1,2,3,4,5] as $g)
                                @if($g <= $remainingMarks)
                                <button type="button" class="qq-quick-btn"
                                        onclick="document.getElementById('gradeInput').value={{ $g }}">{{ $g }}</button>
                                @endif
                                @endforeach
                                @if($remainingMarks > 0)
                                <button type="button" class="qq-quick-btn qq-quick-btn--all"
                                        onclick="document.getElementById('gradeInput').value={{ $remainingMarks }}">
                                    {{ app()->getLocale() == 'ar' ? 'الكل' : 'All' }} ({{ $remainingMarks }})
                                </button>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="qq-label">{{ app()->getLocale() === 'ar' ? 'نوع السؤال' : 'Question Type' }}</label>
                            <div class="qq-type-toggle">
                                <label class="qq-type-option">
                                    <input type="radio" name="type" value="multiple_choice"
                                           {{ old('type','multiple_choice') == 'multiple_choice' ? 'checked' : '' }}
                                           onchange="switchType('multiple_choice')">
                                    <span><i class="fas fa-list-ul mr-1"></i>{{ app()->getLocale() === 'ar' ? 'اختيار متعدد' : 'Multiple Choice' }}</span>
                                </label>
                                <label class="qq-type-option">
                                    <input type="radio" name="type" value="true_false"
                                           {{ old('type') == 'true_false' ? 'checked' : '' }}
                                           onchange="switchType('true_false')">
                                    <span><i class="fas fa-check-double mr-1"></i>{{ app()->getLocale() === 'ar' ? 'صح/خطأ' : 'True/False' }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="qq-label">
                                {{ app()->getLocale() === 'ar' ? 'صورة السؤال' : 'Question Image' }}
                                <small class="text-muted">({{ app()->getLocale() === 'ar' ? 'اختياري' : 'optional' }})</small>
                            </label>
                            <div class="qq-img-upload" onclick="document.getElementById('inp_qimg').click()">
                                <div id="qq_img_prev">
                                    <i class="fas fa-image qq-img-icon"></i>
                                    <span>{{ app()->getLocale() == 'ar' ? 'انقر لرفع صورة' : 'Click to upload' }}</span>
                                </div>
                                <img id="qq_img_preview" src="" alt="" class="qq-img-preview d-none">
                            </div>
                            <input type="file" name="question_image" id="inp_qimg" class="d-none"
                                   accept="image/*" onchange="previewQImg(this)">
                        </div>

                        <div id="mc_options_section">
                            <div class="qq-options-grid">
                                @foreach(['a'=>'A','b'=>'B','c'=>'C','d'=>'D'] as $key => $letter)
                                <div class="form-group">
                                    <label class="qq-label qq-option-label qq-opt-{{ $key }}">{{ $letter }}</label>
                                    <input type="text" name="option_{{ $key }}" value="{{ old('option_'.$key) }}"
                                           class="form-control qq-input qq-option-input"
                                           placeholder="{{ app()->getLocale() === 'ar' ? 'الخيار ' . $letter : 'Option ' . $letter }}">
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label class="qq-label">{{ app()->getLocale() === 'ar' ? 'الإجابة الصحيحة' : 'Correct Answer' }} <span class="qq-required">*</span></label>
                                <div class="qq-correct-grid">
                                    @foreach(['A','B','C','D'] as $letter)
                                    <label class="qq-correct-opt qq-opt-{{ strtolower($letter) }}">
                                        <input type="radio" name="correct_answer" value="{{ $letter }}"
                                               {{ old('correct_answer') == $letter ? 'checked' : '' }}>
                                        <span>{{ $letter }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div id="tf_correct_section" class="d-none">
                            <div class="form-group">
                                <label class="qq-label">{{ app()->getLocale() === 'ar' ? 'الإجابة الصحيحة' : 'Correct Answer' }} <span class="qq-required">*</span></label>
                                <div class="qq-tf-grid">
                                    <label class="qq-tf-opt qq-tf-true">
                                        <input type="radio" name="correct_answer_tf" value="true"
                                               {{ old('correct_answer_tf') == 'true' ? 'checked' : '' }}>
                                        <span>✅ {{ app()->getLocale() === 'ar' ? 'صح' : 'True' }}</span>
                                    </label>
                                    <label class="qq-tf-opt qq-tf-false">
                                        <input type="radio" name="correct_answer_tf" value="false"
                                               {{ old('correct_answer_tf') == 'false' ? 'checked' : '' }}>
                                        <span>❌ {{ app()->getLocale() === 'ar' ? 'خطأ' : 'False' }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="qq-label">{{ app()->getLocale() === 'ar' ? 'ترتيب السؤال' : 'Question Order' }}</label>
                            <input type="number" name="order" value="{{ old('order', $questions->count() + 1) }}"
                                   class="form-control qq-input" min="1">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block qq-add-btn"
                                {{ $isComplete ? 'disabled' : '' }}>
                            <i class="fas fa-plus mr-2"></i>
                            {{ app()->getLocale() === 'ar' ? 'إضافة السؤال' : 'Add Question' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Questions list --}}
        <div class="col-md-7 col-lg-8">
            @if($questions->count() > 0)
            <div class="qq-questions-list">
                @foreach($questions as $i => $q)
                <div class="card border-0 shadow-sm rounded-lg mb-3 qq-question-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-start flex-grow-1" style="gap:14px">
                                <div class="qq-num-badge">{{ $i + 1 }}</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center flex-wrap mb-1" style="gap:8px">
                                        <span class="qq-type-badge {{ $q->type == 'true_false' ? 'qq-type-badge--tf' : 'qq-type-badge--mc' }}">
                                            <i class="fas {{ $q->type == 'true_false' ? 'fa-check-double' : 'fa-list-ul' }} mr-1"></i>
                                            {{ $q->type == 'true_false' ? (app()->getLocale() === 'ar' ? 'صح/خطأ' : 'True/False') : (app()->getLocale() === 'ar' ? 'اختيار متعدد' : 'Multiple Choice') }}
                                        </span>
                                        <span class="qq-grade-badge">
                                            <i class="fas fa-star mr-1"></i>
                                            {{ $q->grade }}{{ app()->getLocale() == 'ar' ? ' علامة' : ' pt' }}
                                        </span>
                                    </div>
                                    <p class="qq-question-text mb-2">{{ $q->question_text }}</p>

                                    @if($q->question_image)
                                    <div class="qq-question-img mb-2">
                                        <img src="{{ asset('assets/admin/uploads/' . $q->question_image) }}"
                                             class="qq-q-img" onclick="openImgModal('{{ asset('assets/admin/uploads/' . $q->question_image) }}')">
                                    </div>
                                    @endif

                                    @if($q->type === 'true_false')
                                    <div class="qq-tf-display">
                                        <span class="qq-tf-item {{ $q->correct_answer == 'true' ? 'correct' : '' }}">
                                            ✅ {{ app()->getLocale() === 'ar' ? 'صح' : 'True' }}
                                            @if($q->correct_answer == 'true')<i class="fas fa-check-circle text-success ml-1"></i>@endif
                                        </span>
                                        <span class="qq-tf-item {{ $q->correct_answer == 'false' ? 'correct' : '' }}">
                                            ❌ {{ app()->getLocale() === 'ar' ? 'خطأ' : 'False' }}
                                            @if($q->correct_answer == 'false')<i class="fas fa-check-circle text-success ml-1"></i>@endif
                                        </span>
                                    </div>
                                    @else
                                    <div class="qq-mc-display">
                                        @foreach(['A'=>$q->option_a,'B'=>$q->option_b,'C'=>$q->option_c,'D'=>$q->option_d] as $letter => $text)
                                        @if($text)
                                        <div class="qq-mc-item {{ $q->correct_answer == $letter ? 'correct' : '' }}">
                                            <span class="qq-mc-letter qq-opt-{{ strtolower($letter) }}">{{ $letter }}</span>
                                            <span class="qq-mc-text">{{ $text }}</span>
                                            @if($q->correct_answer == $letter)<i class="fas fa-check-circle text-success mr-auto"></i>@endif
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <form method="POST" action="{{ route('admin.bag-exams.questions.destroy', $q->id) }}"
                                  style="margin:0;flex-shrink:0"
                                  onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'حذف السؤال؟' : 'Delete question?' }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm qq-delete-btn">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="qq-empty">
                <div class="qq-empty-icon">❓</div>
                <h5>{{ app()->getLocale() === 'ar' ? 'لا توجد أسئلة بعد' : 'No questions yet' }}</h5>
                <p class="text-muted">{{ app()->getLocale() === 'ar' ? 'أضف أول سؤال من النموذج على اليمين.' : 'Add the first question using the form.' }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Image modal --}}
<div class="modal fade" id="imgModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-lg overflow-hidden">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body pt-0 text-center">
                <img id="modalQImg" src="" alt="" style="max-width:100%;border-radius:10px">
            </div>
        </div>
    </div>
</div>

<style>
.qq-card-header { background:#f8f9fa; font-weight:600; font-size:14px; color:#495057; padding:14px 20px; border-bottom:1px solid #e9ecef; display:flex; align-items:center; }
.qq-add-card { position:sticky; top:20px; }
.qq-marks-panel { background:rgba(255,255,255,.98); border:2px solid #e9ecef; border-radius:14px; padding:16px 20px; margin-bottom:22px; transition:border-color .3s; }
.qq-marks-panel--complete { border-color:rgba(40,167,69,.4); }
.qq-marks-panel--over { border-color:rgba(220,53,69,.4); }
.qq-marks-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
.qq-marks-label { font-size:13px; font-weight:700; color:#495057; }
.qq-marks-numbers { display:flex; align-items:center; gap:6px; }
.qq-marks-used { font-size:24px; font-weight:800; color:#667eea; }
.qq-marks-sep { color:#ccc; font-size:18px; }
.qq-marks-total { font-size:18px; font-weight:700; color:#333; }
.qq-marks-complete-badge { background:rgba(40,167,69,.12); color:#28a745; font-size:12px; font-weight:700; padding:3px 10px; border-radius:20px; }
.qq-marks-remaining-badge { background:rgba(102,126,234,.1); color:#667eea; font-size:12px; font-weight:600; padding:3px 10px; border-radius:20px; }
.qq-marks-over-badge { background:rgba(220,53,69,.1); color:#dc3545; font-size:12px; font-weight:700; padding:3px 10px; border-radius:20px; }
.qq-marks-bar-wrap { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
.qq-marks-bar { flex:1; height:10px; background:#eee; border-radius:6px; overflow:hidden; }
.qq-marks-bar-fill { height:100%; background:linear-gradient(90deg,#667eea,#764ba2); border-radius:6px; transition:width .6s; }
.qq-marks-panel--complete .qq-marks-bar-fill { background:linear-gradient(90deg,#28a745,#20c997); }
.qq-marks-pct { font-size:13px; font-weight:700; color:#666; width:38px; text-align:right; flex-shrink:0; }
.qq-marks-chips { display:flex; flex-wrap:wrap; gap:6px; }
.qq-marks-chip { display:flex; flex-direction:column; align-items:center; background:rgba(102,126,234,.08); border:1px solid rgba(102,126,234,.15); border-radius:8px; padding:4px 8px; min-width:40px; }
.qq-marks-chip--empty { background:rgba(0,0,0,.04); border-style:dashed; border-color:#ccc; }
.qq-chip-num { font-size:10px; color:#888; }
.qq-chip-grade { font-size:13px; font-weight:700; color:#667eea; }
.qq-marks-chip--empty .qq-chip-grade { color:#aaa; }
.qq-grade-input { font-size:18px; font-weight:700; text-align:center; color:#f7971e; }
.qq-grade-suffix { font-size:12px; background:#f8f9fa; color:#555; }
.qq-quick-grades { display:flex; gap:6px; flex-wrap:wrap; }
.qq-quick-btn { padding:4px 12px; border:1px solid #ddd; background:white; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; transition:all .15s; color:#555; }
.qq-quick-btn:hover { border-color:#f7971e; color:#f7971e; }
.qq-quick-btn--all { border-color:#667eea; color:#667eea; }
.qq-grade-badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:700; background:rgba(247,151,30,.12); color:#c07800; }
.qq-label { font-size:13px; font-weight:600; color:#495057; margin-bottom:7px; display:block; }
.qq-required { color:#dc3545; }
.qq-input { border-radius:10px; border-color:#e0e0e0; font-size:14px; padding:10px 14px; transition:all .2s; }
.qq-input:focus { border-color:#667eea; box-shadow:0 0 0 3px rgba(102,126,234,.12); }
.qq-type-toggle { display:flex; gap:8px; }
.qq-type-option { flex:1; cursor:pointer; margin:0; }
.qq-type-option input { display:none; }
.qq-type-option span { display:flex; align-items:center; justify-content:center; padding:10px; border:2px solid #e0e0e0; border-radius:10px; font-size:13px; font-weight:600; color:#888; transition:all .2s; }
.qq-type-option input:checked + span { border-color:#667eea; background:rgba(102,126,234,.08); color:#667eea; }
.qq-img-upload { border:2px dashed #d0d0d0; border-radius:10px; padding:14px; text-align:center; cursor:pointer; transition:all .25s; background:#fafafa; min-height:65px; display:flex; align-items:center; justify-content:center; }
.qq-img-upload:hover { border-color:#667eea; }
.qq-img-icon { font-size:18px; color:#aaa; display:block; margin-bottom:3px; }
#qq_img_prev { display:flex; flex-direction:column; align-items:center; }
#qq_img_prev span { font-size:12px; color:#888; }
.qq-img-preview { width:100%; max-height:70px; object-fit:cover; border-radius:8px; }
.qq-options-grid { display:grid; grid-template-columns:1fr 1fr; gap:0 12px; }
.qq-option-label { width:22px; height:22px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:11px; font-weight:800; color:white; margin-bottom:5px; }
.qq-opt-a { background:#667eea; } .qq-opt-b { background:#f5576c; } .qq-opt-c { background:#f7971e; } .qq-opt-d { background:#43e97b; color:#005a1f; }
.qq-option-input { font-size:13px; padding:8px 12px; }
.qq-correct-grid { display:flex; gap:8px; }
.qq-correct-opt { flex:1; cursor:pointer; margin:0; }
.qq-correct-opt input { display:none; }
.qq-correct-opt span { display:flex; align-items:center; justify-content:center; width:100%; padding:10px; border-radius:10px; font-size:15px; font-weight:800; color:white; transition:all .2s; opacity:.5; }
.qq-correct-opt input:checked + span { opacity:1; transform:scale(1.05); }
.qq-correct-opt.qq-opt-a span { background:#667eea; } .qq-correct-opt.qq-opt-b span { background:#f5576c; } .qq-correct-opt.qq-opt-c span { background:#f7971e; } .qq-correct-opt.qq-opt-d span { background:#43e97b; color:#005a1f; }
.qq-tf-grid { display:flex; gap:8px; }
.qq-tf-opt { flex:1; cursor:pointer; margin:0; }
.qq-tf-opt input { display:none; }
.qq-tf-opt span { display:flex; align-items:center; justify-content:center; padding:10px; border:2px solid #e0e0e0; border-radius:10px; font-size:14px; font-weight:600; transition:all .2s; }
.qq-tf-true input:checked + span { border-color:#28a745; background:rgba(40,167,69,.08); color:#28a745; }
.qq-tf-false input:checked + span { border-color:#dc3545; background:rgba(220,53,69,.08); color:#dc3545; }
.qq-add-btn { border-radius:10px; padding:12px; font-size:15px; font-weight:600; }
.qq-num-badge { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#667eea,#764ba2); color:white; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; flex-shrink:0; }
.qq-question-card:hover { box-shadow:0 8px 25px rgba(0,0,0,.1) !important; }
.qq-type-badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
.qq-type-badge--mc { background:rgba(102,126,234,.1); color:#667eea; }
.qq-type-badge--tf { background:rgba(67,233,123,.1); color:#0ba360; }
.qq-question-text { font-size:15px; font-weight:600; color:#333; margin:0; }
.qq-question-img .qq-q-img { max-height:80px; border-radius:8px; cursor:pointer; border:1px solid #e9ecef; }
.qq-mc-display { display:flex; flex-direction:column; gap:5px; }
.qq-mc-item { display:flex; align-items:center; gap:8px; padding:6px 10px; border-radius:8px; font-size:13px; background:#f8f9fa; border:1px solid #eee; }
.qq-mc-item.correct { background:rgba(40,167,69,.08); border-color:rgba(40,167,69,.25); }
.qq-mc-letter { width:22px; height:22px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:800; color:white; flex-shrink:0; }
.qq-mc-text { flex:1; color:#555; }
.qq-tf-display { display:flex; gap:8px; flex-wrap:wrap; }
.qq-tf-item { display:flex; align-items:center; gap:5px; padding:5px 12px; border-radius:20px; font-size:13px; background:#f8f9fa; border:1px solid #eee; }
.qq-tf-item.correct { background:rgba(40,167,69,.08); border-color:rgba(40,167,69,.3); font-weight:600; }
.qq-delete-btn { background:transparent; color:#ccc; border:none; padding:5px 8px; border-radius:8px; transition:all .2s; }
.qq-delete-btn:hover { background:rgba(220,53,69,.1); color:#dc3545; }
.qq-empty { text-align:center; padding:50px 20px; }
.qq-empty-icon { font-size:50px; display:block; margin-bottom:14px; }
</style>

<script>
function switchType(type) {
    const isTF = type === 'true_false';
    document.getElementById('mc_options_section').classList.toggle('d-none', isTF);
    document.getElementById('tf_correct_section').classList.toggle('d-none', !isTF);
    const mcCorrect = document.querySelector('[name="correct_answer"]');
    const tfCorrect = document.querySelector('[name="correct_answer_tf"]');
    if (mcCorrect && tfCorrect) {
        if (isTF) {
            mcCorrect.setAttribute('name', 'correct_answer_disabled');
            tfCorrect.setAttribute('name', 'correct_answer');
        } else {
            tfCorrect.setAttribute('name', 'correct_answer_tf');
            mcCorrect.setAttribute('name', 'correct_answer');
        }
    }
}

function previewQImg(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('qq_img_preview').src = e.target.result;
        document.getElementById('qq_img_preview').classList.remove('d-none');
        document.getElementById('qq_img_prev').classList.add('d-none');
    };
    reader.readAsDataURL(file);
}

function openImgModal(src) {
    document.getElementById('modalQImg').src = src;
    $('#imgModal').modal('show');
}

const gradeInput = document.getElementById('gradeInput');
const remaining = {{ $remainingMarks }};
if (gradeInput) {
    gradeInput.setAttribute('max', remaining);
    gradeInput.addEventListener('input', function() {
        if (parseInt(this.value) > remaining) this.value = remaining;
    });
}

const checkedType = document.querySelector('[name="type"]:checked');
if (checkedType) switchType(checkedType.value);

$(function() { $('[data-toggle="tooltip"]').tooltip(); });
</script>
@endsection
