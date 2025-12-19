<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->id('material_id');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('file_type', 50);
            $table->foreignId('teacher_id')->constrained('teachers', 'teacher_id')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections', 'section_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('learning_materials');
    }
};