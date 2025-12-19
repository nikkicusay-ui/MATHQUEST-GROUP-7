@extends('teacher.layouts.app')

@section('content')
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
            <a href="{{ route('teacher.sections.index') }}" class="nav-item">
                <i class="fas fa-users nav-icon"></i><span>Sections & Students</span>
            </a>
            <a href="{{ route('teacher.modules.index') }}" class="nav-item">
                <i class="fas fa-book-open nav-icon"></i><span>Learning Materials</span>
            </a>
            <a href="{{ route('teacher.quizzes.index') }}" class="nav-item">
                <i class="fas fa-clipboard-list nav-icon"></i><span>Quizzes</span>
            </a>
            <a href="{{ route('teacher.reports') }}" class="nav-item">
                <i class="fas fa-chart-line nav-icon"></i><span>Reports & Analytics</span>
            </a>
            <a href="{{ route('teacher.settings') }}" class="nav-item">
                <i class="fas fa-cog nav-icon"></i><span>Settings</span>
            </a>
            <a href="{{ route('teacher.logout') }}" class="nav-item" id="logout-btn">
                <i class="fas fa-sign-out-alt nav-icon"></i><span>Logout</span>
            </a>
        </nav>
        <div class="user-profile">
            <a href="{{ route('teacher.settings') }}">
                <div class="user-avatar" id="user-avatar">
                    @if($teacher->avatar)
                        <img src="{{ $teacher->avatar }}" alt="Avatar" style="width:100%; height:100%; border-radius:50%;">
                    @else
                        {{ $teacher->initials }}
                    @endif
                </div>
            </a>
            <div class="user-info">
                <h4 id="user-name">{{ $teacher->full_name }}</h4>
                <p id="user-type">{{ $teacher->position ?? 'Teacher' }}</p>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <div class="welcome-banner">
            <h2 id="welcome-message">Teacher Dashboard - Manage Your Math Classes</h2>
            <p>Welcome to your MathQuest Teacher Portal. Monitor your student's progress, create and upload learning materials, and manage your Grade 3 Mathematics classes all in one place.</p>
        </div>

        <div class="stats-cards">
            <div class="stat-card sections">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h3>{{ $sections->count() }}</h3>
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
                <h2><i class="fas fa-chart-bar"></i>Overall Class Performance</h2>
            </div>
            <div>
                <span><strong>Average Score:</strong> {{ $class_average_score }}%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ floatval($class_average_score) }}%;"></div>
            </div>
            <p style="margin-top: 15px; font-size: 15px; color: #666;">
                <i class="fas fa-lightbulb" style="margin-right: 8px; color: var(--accent-color);"></i>
                Class average score across all sections for the current quarter. Monitor individual section performance in the Reports section.
            </p>
        </div>

        <div class="progress-section">
            <div class="section-header">
                <h2><i class="fas fa-history"></i>Recent Activity</h2>
            </div>
            <div class="activity-list">
                @forelse($recent_activities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fas {{ $activity['icon'] }}"></i></div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $activity['title'] }}</div>
                            <div class="activity-desc">{{ $activity['desc'] }}</div>
                            <div class="activity-time">{{ $activity['time'] }}</div>
                        </div>
                    </div>
                @empty
                    <div class="no-activity">No recent activity.</div>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection
