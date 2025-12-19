@extends('teacher.layouts.app')

@section('title','Quizzes | MathQuest')

@section('content')
<div class="page-header">
    <h1>Quizzes</h1>
    <div class="header-info">
        <div class="current-week-badge">
            <i class="fas fa-calendar-alt"></i>
            <span>Current: {{ $current_quarter }} Quarter, Week {{ $current_week }}</span>
        </div>
        <a href="{{ route('teacher.quizzes.create') }}" class="create-quiz-btn">
            <i class="fas fa-plus"></i> Create New Quiz
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Stats Cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $quizzes->count() }}</div>
        <div class="stat-label">Total Quizzes</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $total_questions }}</div>
        <div class="stat-label">Total Questions</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $quizzes->sum(fn($q) => $q->studentQuizzes->count()) }}</div>
        <div class="stat-label">Total Quiz Attempts</div>
    </div>
</div>

{{-- Question Stats --}}
@include('teacher.components.question-stats')

{{-- Quiz Filters --}}
@include('teacher.components.quiz-filters')

{{-- Quizzes List --}}
<div class="quizzes-grid" id="quizzes-container">
    @forelse($quizzes as $quiz)
    <div class="quiz-card" data-quarter="{{ $quiz->quarter }}" data-week="{{ $quiz->week }}" data-type="{{ $quiz->quiz_type }}">
        <div class="quiz-header">
            <h3>Quiz #{{ $quiz->quiz_id }}</h3>
        </div>
        <div class="quiz-info">
            <p><strong>Assigned to:</strong> {{ $quiz->sections->pluck('section_name')->join(', ') ?: 'No sections' }}</p>
            <p><strong>Questions:</strong> {{ $quiz->questions->count() }}</p>
            <p><strong>Total Points:</strong> {{ $quiz->questions->sum('points') }}</p>
            <p><strong>Students Taken:</strong> {{ $quiz->studentQuizzes->count() }}</p>
        </div>
        <div class="actions">
            <a href="{{ route('teacher.quizzes.show',$quiz->quiz_id) }}" class="btn btn-small btn-view">
                <i class="fas fa-eye"></i> View
            </a>
            <a href="{{ route('teacher.quizzes.edit',$quiz->quiz_id) }}" class="btn btn-small btn-edit">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('teacher.quizzes.destroy', $quiz->quiz_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-small btn-delete"><i class="fas fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>
    @empty
    <p>No quizzes found. Create your first quiz!</p>
    @endforelse
</div>
@endsection
