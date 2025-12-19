<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard | MathQuest</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Orbitron:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/teacher/dashboard.css') }}">
</head>

<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo" id="sidebarToggle">
                <i class="fas fa-gamepad logo-icon"></i>
                <div class="logo-text">MATHQUEST</div>
            </div>
            <nav class="nav-menu">
                <a href="{{ route('teacher.dashboard') }}" class="nav-item active">
                    <i class="fas fa-home nav-icon"></i><span>Dashboard</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-users nav-icon"></i><span>Sections & Students</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-book-open nav-icon"></i><span>Learning Materials</span>
                </a>
                <a href="#" class="nav-item">
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
                    <h4 id="user-name">{{ $teacher->first_name }} {{ $teacher->last_name }}</h4>
                    <p id="user-type">{{ $teacher->position }}</p>
                </div>
            </div>
        </aside>
        <main class="main-content">
            <div class="welcome-banner">
                <h2 id="welcome-message">Teacher Dashboard - Manage Your Math Classes</h2>
                <p>Welcome to your MathQuest Teacher Portal. Monitor your student's<br>progress, create and upload learning materials, and manage<br>your Grade 3 Mathematics classes all in one place.</p>
            </div>

            <header class="top-header">
                <h1>Teacher Dashboard</h1>
            </header>

            <div class="stats-cards">
                <div class="stat-card sections">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-info">
                        <h3>{{ count($sections) }}</h3>
                        <p>Total Sections</p>
                    </div>
                </div>

                <div class="stat-card students">
                    <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                    <div class="stat-info">
                        <h3>{{ $students_count }}</h3>
                        <p>Total Students</p>
                    </div>
                </div>

                <div class="stat-card materials">
                    <div class="stat-icon"><i class="fas fa-book"></i></div>
                    <div class="stat-info">
                        <h3>{{ $materials_count }}</h3>
                        <p>Learning Materials</p>
                    </div>
                </div>

                <div class="stat-card quizzes">
                    <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
                    <div class="stat-info">
                        <h3>{{ $quizzes_count }}</h3>
                        <p>Total Quizzes</p>
                    </div>
                </div>
            </div>

            <div class="progress-section">
                <div class="section-header">
                    <h2><i class="fas fa-history"></i>Recent Activity</h2>
                </div>
                <div class="activity-list">
                    @if(!empty($recent_activities))
                        @foreach($recent_activities as $activity)
                            <div class="activity-item">
                                <div class="activity-icon"><i class="fas {{ $activity['icon'] }}"></i></div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $activity['title'] }}</div>
                                    <div class="activity-desc">{{ $activity['desc'] }}</div>
                                    <div class="activity-time">{{ $activity['time'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-activity">No recent activity.</div><br>
                    @endif
                </div>
            </div>

            <div class="progress-section">
                <div class="section-header">
                    <h2><i class="fas fa-chart-bar"></i>Overall Class Performance</h2>
                </div>

                <div style="margin-bottom: 20px;">
                    <span><strong>Average Score:</strong> {{ $class_average_score }}%</span>
                </div>

                <div class="progress-bar">
                    <div class="progress-fill" id="class-performance" style="width: {{ floatval($class_average_score) }}%;"></div>
                </div>

                <p style="margin-top: 15px; font-size: 15px; color: #666;">
                    <i class="fas fa-lightbulb" style="margin-right: 8px; color: var(--accent-color);"></i>
                    Class average score across all sections for the current quarter. Monitor individual section performance in the Reports section.
                </p>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/teacher/dashboard.js') }}"></script>
</body>
</html>