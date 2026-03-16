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
       Schema::create('top_students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('school_name')->nullable();
            $table->decimal('average', 5, 2)->nullable();
            $table->string('rank')->nullable(); // 1st, 2nd, 3rd...
            $table->string('photo')->nullable();           // student photo
            $table->string('grades_photo')->nullable();    // grades sheet photo
            $table->string('certificate_photo')->nullable(); // certificate photo
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('top_students');
    }
};
