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
         Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('duration_minutes')->default(30); // time limit in minutes
            $table->boolean('is_active')->default(true);
            $table->string('whatsapp_a')->nullable(); // link for score >= 25
            $table->string('whatsapp_b')->nullable(); // link for score 18-24
            $table->string('whatsapp_c')->nullable(); // link for score < 18
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
        Schema::dropIfExists('quizzes');
    }
};
