<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pdf_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pdf_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('pdf_subcategory_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('filename');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pdf_files');
    }
};
