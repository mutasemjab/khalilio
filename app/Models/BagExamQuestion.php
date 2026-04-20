<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BagExamQuestion extends Model
{
    protected $fillable = [
        'bag_exam_id', 'question_text', 'question_image',
        'type', 'correct_answer',
        'option_a', 'option_b', 'option_c', 'option_d',
        'order', 'grade',
    ];

    public function exam()
    {
        return $this->belongsTo(BagExam::class, 'bag_exam_id');
    }
}
