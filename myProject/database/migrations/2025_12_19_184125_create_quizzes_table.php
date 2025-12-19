<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id('quiz_id');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->foreignId('teacher_id')->constrained('teachers', 'teacher_id')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections', 'section_id')->onDelete('cascade');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
};