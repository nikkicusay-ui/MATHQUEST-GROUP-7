<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Quizzes | MathQuest</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/teacher/quizzes.css') }}">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo" id="sidebarToggle">
                <i class="fas fa-gamepad logo-icon"></i>
                <div class="logo-text">MATHQUEST</div>
            </div>
            <nav class="nav-menu">
                <a href="{{ route('teacher.dashboard') }}" class="nav-item">
                    <i class="fas fa-home nav-icon"></i><span>Dashboard</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-users nav-icon"></i><span>Sections & Students</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-book-open nav-icon"></i><span>Learning Materials</span>
                </a>
                <a href="{{ route('teacher.quizzes') }}" class="nav-item active">
                    <i class="fas fa-clipboard-list nav-icon"></i><span>Quizzes</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-chart-line nav-icon"></i><span>Reports & Analytics</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-cog nav-icon"></i><span>Settings</span>
                </a>
                <form action="{{ route('teacher.logout') }}" method="POST" class="nav-item logout-form">
                    @csrf
                    <button type="submit" class="logout-btn" style="background: none; border: none; color: inherit; cursor: pointer; text-align: left; width: 100%;">
                        <i class="fas fa-sign-out-alt nav-icon"></i><span>Logout</span>
                    </button>
                </form>
            </nav>
            <div class="user-profile">
                <a href="#">
                    <div class="user-avatar" id="user-avatar">
                        {{ $sidebar_initials }}
                    </div>
                </a>
                <div class="user-info">
                    <h4 id="user-name">{{ $teacher_name }}</h4>
                    <p id="user-type">{{ $teacher->position }}</p>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>Quizzes</h1>
                <div class="header-info">
                    <div class="current-week-badge">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Current: {{ $current_quarter }} Quarter, Week {{ $current_week }}</span>
                    </div>
                    <a href="#" class="create-quiz-btn">
                        <i class="fas fa-plus"></i>
                        Create New Quiz
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{{ count($quizzes) }}</div>
                    <div class="stat-label">Total Quizzes</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value">{{ $total_questions }}</div>
                    <div class="stat-label">Total Questions</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value">
                        {{ $quizzes->sum('students_taken') ?: 0 }}
                    </div>
                    <div class="stat-label">Total Quiz Attempts</div>
                </div>
            </div>

            <div class="filters-section">
                <div class="filters-header">
                    <h3><i class="fas fa-database"></i> Question Bank Statistics</h3>
                </div>
                <div class="question-stats">
                    @foreach($question_stats as $difficulty => $stats)
                        <div class="question-stat-card {{ strtolower($difficulty) }}">
                            <div class="stat-header">
                                <h4>{{ $difficulty }} Questions</h4>
                                <span class="total-count">{{ $stats['total'] }} total</span>
                            </div>
                            <div class="stat-details">
                                <div class="stat-detail">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ $stats['correct'] ?: 0 }} correct answers</span>
                                </div>
                                <div class="stat-detail">
                                    <i class="fas fa-play-circle"></i>
                                    <span>{{ $stats['used'] ?: 0 }} times used</span>
                                </div>
                                @if($stats['used'] > 0)
                                <div class="stat-detail">
                                    <i class="fas fa-percentage"></i>
                                    <span>{{ round(($stats['correct'] / $stats['used']) * 100, 1) }}% success rate</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="filters-section">
                <div class="filters-header">
                    <h3><i class="fas fa-filter"></i> Filter Quizzes</h3>
                </div>
                <div class="filter-controls">
                    <div class="filter-group">
                        <label for="quarter-filter"><i class="fas fa-layer-group"></i> Quarter</label>
                        <select id="quarter-filter" class="filter-select">
                            <option value="all">All Quarters</option>
                            <option value="1st">1st Quarter</option>
                            <option value="2nd">2nd Quarter</option>
                            <option value="3rd">3rd Quarter</option>
                            <option value="4th">4th Quarter</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="week-filter"><i class="fas fa-calendar-week"></i> Week</label>
                        <select id="week-filter" class="filter-select">
                            <option value="all">All Weeks</option>
                            @for($i = 1; $i <= 52; $i++)
                                <option value="{{ $i }}">Week {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="type-filter"><i class="fas fa-tag"></i> Quiz Type</label>
                        <select id="type-filter" class="filter-select">
                            <option value="all">All Types</option>
                            <option value="Mixed">Mixed</option>
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="quizzes-grid" id="quizzes-container">
                @if($quizzes->isEmpty())
                    <div class="no-quizzes">
                        <i class="fas fa-clipboard-list"></i>
                        <h3>No Quizzes Found</h3>
                        <p>Create your first quiz to get started!</p>
                        <a href="#" class="create-quiz-btn" style="margin-top: 20px;">
                            <i class="fas fa-plus"></i>
                            Create First Quiz
                        </a>
                    </div>
                @else
                    @foreach($quizzes as $quiz)
                        <div class="quiz-card {{ ($quiz->quarter == $current_quarter && $quiz->week == $current_week) ? 'current' : '' }}"
                             data-quarter="{{ $quiz->quarter }}"
                             data-week="{{ $quiz->week }}"
                             data-type="{{ $quiz->quiz_type }}">
                            <div class="quiz-badge quiz-{{ strtolower($quiz->quiz_type) }}">
                                <i class="fas fa-{{ $this->getQuizTypeIcon($quiz->quiz_type) }}"></i>
                                {{ $quiz->quiz_type }}
                            </div>
                            <div class="quiz-header">
                                <div class="quiz-quarter">
                                    <i class="fas fa-layer-group"></i>
                                    {{ $quiz->quarter }} Quarter, Week {{ $quiz->week }}
                                </div>
                                <h3 class="quiz-title">Quiz #{{ $quiz->quiz_id }}</h3>
                            </div>
                            <div class="quiz-meta">
                                <div class="quiz-type">
                                    <i class="fas fa-tag"></i>
                                    {{ $quiz->quiz_type }} Type
                                </div>
                                <div class="quiz-date">
                                    <i class="fas fa-calendar"></i>
                                    {{ $quiz->date_created->format('M j, Y') }}
                                </div>
                            </div>
                            <div class="quiz-info">
                                <p><strong>Assigned to:</strong> {{ $quiz->sections_count ? $quiz->sections_count . ' section(s)' : 'No sections' }}</p>
                                <p><strong>Questions:</strong> {{ $quiz->question_count }} questions</p>
                                <p><strong>Total Points:</strong> {{ $quiz->total_points }}</p>
                                @if($quiz->students_taken > 0)
                                    <p><strong>Average Score:</strong> {{ round($quiz->average_score, 2) }}%</p>
                                    <p><strong>Students Taken:</strong> {{ $quiz->students_taken }}</p>
                                @else
                                    <p><em>No students have taken this quiz yet</em></p>
                                @endif
                            </div>
                            <div class="actions">
                                <a href="#" class="btn btn-small btn-view">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="#" class="btn btn-small btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('teacher.quizzes.destroy', $quiz->quiz_id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-small btn-delete" onclick="return confirm('Are you sure you want to delete this quiz?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </main>
    </div>

    <script src="{{ asset('js/teacher/sidebar.js') }}"></script>
    <script src="{{ asset('js/teacher/quizzes.js') }}"></script>
    <script>
        function getQuizTypeIcon(type) {
            switch (type) {
                case 'Mixed': return 'random';
                case 'Easy': return 'seedling';
                case 'Medium': return 'mountain';
                case 'Hard': return 'fire';
                default: return 'question';
            }
        }
    </script>
</body>
</html>