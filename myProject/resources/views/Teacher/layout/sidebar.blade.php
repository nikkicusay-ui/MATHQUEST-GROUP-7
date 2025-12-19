<aside class="sidebar">
    <div class="logo" id="sidebarToggle">
        <i class="fas fa-gamepad logo-icon"></i>
        <div class="logo-text">MATHQUEST</div>
    </div>
    <nav class="nav-menu">
        <a href="{{ route('teacher.dashboard') }}" class="nav-item">
            <i class="fas fa-home nav-icon"></i><span>Dashboard</span>
        </a>
        <a href="{{ route('teacher.sections.index') }}" class="nav-item">
            <i class="fas fa-users nav-icon"></i><span>Sections & Students</span>
        </a>
        <a href="{{ route('teacher.modules.index') }}" class="nav-item">
            <i class="fas fa-book-open nav-icon"></i><span>Learning Materials</span>
        </a>
        <a href="{{ route('teacher.quizzes.index') }}" class="nav-item active">
            <i class="fas fa-clipboard-list nav-icon"></i><span>Quizzes</span>
        </a>
        <a href="{{ route('teacher.reports.index') }}" class="nav-item">
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
                @if($teacher->profile_image && file_exists(public_path($teacher->profile_image)))
                    <img src="{{ asset($teacher->profile_image) }}" alt="Avatar" class="rounded-full">
                @else
                    {{ strtoupper(substr($teacher->first_name,0,1) . substr($teacher->last_name,0,1)) }}
                @endif
            </div>
        </a>
        <div class="user-info">
            <h4 id="user-name">{{ $teacher->first_name }} {{ $teacher->last_name }}</h4>
            <p id="user-type">{{ $teacher->position ?? 'Teacher' }}</p>
        </div>
    </div>
</aside>
