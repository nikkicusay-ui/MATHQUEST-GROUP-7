<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id('section_id');
            $table->string('section_name', 100);
            $table->foreignId('teacher_id')->constrained('teachers', 'teacher_id')->onDelete('cascade');
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sections');
    }
};