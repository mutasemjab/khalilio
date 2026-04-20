<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bag_exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bag_exam_id')->constrained('bag_exams')->cascadeOnDelete();
            $table->string('student_name');
            $table->string('student_phone')->nullable();
            $table->unsignedSmallInteger('score')->default(0);
            $table->unsignedSmallInteger('total_marks');
            $table->unsignedSmallInteger('total_questions');
            $table->json('answers');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bag_exam_attempts');
    }
};
