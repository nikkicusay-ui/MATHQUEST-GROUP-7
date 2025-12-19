// database/migrations/[timestamp]_create_quizzes_table.php

Schema::create('quizzes', function (Blueprint $table) {
    $table->id('quiz_id');
    $table->string('quarter', 10);
    $table->integer('week');
    $table->string('quiz_type', 20);
    $table->decimal('score', 5, 2)->nullable();
    $table->foreignId('teacher_id')->constrained('teachers', 'teacher_id')->onDelete('cascade');
    $table->timestamp('date_created')->useCurrent();
    $table->timestamps();
});