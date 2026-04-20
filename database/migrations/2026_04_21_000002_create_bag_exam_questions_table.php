<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bag_exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bag_exam_id')->constrained('bag_exams')->cascadeOnDelete();
            $table->text('question_text');
            $table->string('question_image')->nullable();
            $table->enum('type', ['multiple_choice', 'true_false'])->default('multiple_choice');
            $table->string('correct_answer');
            $table->string('option_a')->nullable();
            $table->string('option_b')->nullable();
            $table->string('option_c')->nullable();
            $table->string('option_d')->nullable();
            $table->unsignedSmallInteger('order')->default(0);
            $table->unsignedSmallInteger('grade')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bag_exam_questions');
    }
};
