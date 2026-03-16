<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->string('student_name');
            $table->string('student_phone')->nullable();
            $table->integer('score')->default(0);
            $table->integer('total_questions')->default(0);
            $table->enum('group', ['A', 'B', 'C'])->nullable();
            $table->json('answers')->nullable(); // store all answers
            $table->unsignedInteger('total_marks')->default(30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
