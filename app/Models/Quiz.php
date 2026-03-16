<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
     protected $guarded = [];
     
     protected $casts = [
        'total_marks' => 'integer',
    ];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Sum of grades assigned to all questions.
     */
    public function currentGradesSum(): int
    {
        return (int) $this->questions()->sum('grade');
    }

    /**
     * How many marks are still unassigned.
     */
    public function remainingMarks(): int
    {
        return max(0, $this->total_marks - $this->currentGradesSum());
    }
}
