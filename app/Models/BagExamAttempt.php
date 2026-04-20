<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BagExamAttempt extends Model
{
    protected $fillable = [
        'bag_exam_id', 'student_name', 'student_phone',
        'score', 'total_marks', 'total_questions', 'answers',
    ];

    protected $casts = ['answers' => 'array'];

    public function exam()
    {
        return $this->belongsTo(BagExam::class, 'bag_exam_id');
    }
}
