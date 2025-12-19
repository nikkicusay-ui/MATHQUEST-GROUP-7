@extends('layouts.teacher')

@section('title', 'Learning Materials | MathQuest')

@section('content')
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
            <a href="{{ route('teacher.sections') }}" class="nav-item">
                <i class="fas fa-users nav-icon"></i><span>Sections & Students</span>
            </a>
            <a href="{{ route('teacher.modules') }}" class="nav-item active">
                <i class="fas fa-book-open nav-icon"></i><span>Learning Materials</span>
            </a>
            <a href="{{ route('teacher.quizzes') }}" class="nav-item">
                <i class="fas fa-clipboard-list nav-icon"></i><span>Quizzes</span>
            </a>
            <a href="{{ route('teacher.reports') }}" class="nav-item">
                <i class="fas fa-chart-line nav-icon"></i><span>Reports & Analytics</span>
            </a>
            <a href="{{ route('teacher.settings') }}" class="nav-item">
                <i class="fas fa-cog nav-icon"></i><span>Settings</span>
            </a>
            <a href="{{ route('logout') }}" class="nav-item">
                <i class="fas fa-sign-out-alt nav-icon"></i><span>Logout</span>
            </a>
        </nav>
        <div class="user-profile">
            <a href="{{ route('teacher.settings') }}">
                <div class="user-avatar" id="user-avatar">
                    @if($teacher->profile_image && file_exists(public_path($teacher->profile_image)))
                    <img src="{{ asset($teacher->profile_image) }}" alt="Avatar" class="rounded-full w-full h-full">
                    @else
                    {{ strtoupper(substr($teacher->first_name,0,1) . substr($teacher->last_name,0,1)) }}
                    @endif
                </div>
            </a>
            <div class="user-info">
                <h4>{{ $teacher->first_name }} {{ $teacher->last_name }}</h4>
                <p>{{ $teacher->position ?? 'Teacher' }}</p>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <div class="page-header">
            <h1>Learning Materials</h1>
            <div class="header-info">
                <div class="current-week-badge">
                    <i class="fas fa-calendar-alt"></i>
                    Current: {{ $settings->current_quarter ?? '1st' }} Quarter, Week {{ $settings->current_week ?? 1 }}
                </div>
                <button class="btn btn-primary" onclick="openUploadModal()">
                    <i class="fas fa-upload"></i> Upload Material
                </button>
            </div>
        </div>

        {{-- Success/Error Messages --}}
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        {{-- Settings Form --}}
        <div class="settings-section">
            <div class="settings-header">
                <h3><i class="fas fa-cog"></i> Current Academic Settings</h3>
            </div>
            <form method="POST" action="{{ route('teacher.modules.updateSettings') }}">
                @csrf
                <div class="settings-controls">
                    <div class="setting-group">
                        <label for="current_quarter">Current Quarter:</label>
                        <select id="current_quarter" name="current_quarter" class="setting-select" required>
                            @foreach(['1st','2nd','3rd','4th'] as $q)
                            <option value="{{ $q }}" {{ ($settings->current_quarter ?? '1st') == $q ? 'selected' : '' }}>{{ $q }} Quarter</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="setting-group">
                        <label for="current_week">Current Week:</label>
                        <select id="current_week" name="current_week" class="setting-select" required>
                            @for($i=1; $i<=8; $i++)
                                <option value="{{ $i }}" {{ ($settings->current_week ?? 1) == $i ? 'selected' : '' }}>Week {{ $i }}</option>
                                @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Settings</button>
                </div>
            </form>
        </div>

        {{-- Featured Material --}}
        @if($current_material)
        <div class="featured-section">
            <div class="featured-label">
                <i class="fas fa-star"></i> Featured This Week
            </div>
            <div class="featured-header">
                <h2>{{ $current_material->title }}</h2>
                <div class="featured-meta">
                    <span class="meta-tag"><i class="fas fa-layer-group"></i> {{ $current_material->quarter }} Quarter</span>
                    <span class="meta-tag"><i class="fas fa-calendar-week"></i> Week {{ $current_material->week }}</span>
                    <span class="meta-tag"><i class="fas fa-tag"></i> {{ $current_material->type }}</span>
                </div>
            </div>
            <div class="featured-content">
                @if($current_material->description)
                <p>{{ $current_material->description }}</p>
                @endif
                <div class="featured-actions">
                    @if($current_material->file_path)
                    <a href="{{ asset($current_material->file_path) }}" target="_blank" class="btn btn-primary"><i class="fas fa-eye"></i> View</a>
                    <form method="POST" action="{{ route('teacher.modules.delete', $current_material) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-secondary"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                    @elseif($current_material->url)
                    <a href="{{ $current_material->url }}" target="_blank" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Visit Link</a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Materials Grid --}}
        <div class="materials-grid" id="materials-container">
            @forelse($materials as $material)
            <div class="material-card {{ ($material->quarter == ($settings->current_quarter ?? '1st') && $material->week == ($settings->current_week ?? 1)) ? 'current' : '' }}">
                <div class="material-badge {{ strtolower(str_replace(['/', ' '], '-', $material->type)) }}-badge">
                    <i class="{{ getTypeIcon($material->type) }}"></i> {{ $material->type }}
                </div>
                <div class="material-header">
                    <h3>{{ $material->title }}</h3>
                    <div class="material-quarter"><i class="fas fa-layer-group"></i> {{ $material->quarter }} Quarter</div>
                    <div class="material-week"><i class="fas fa-calendar-week"></i> Week {{ $material->week }}</div>
                </div>
                @if($material->description)
                <p>{{ $material->description }}</p>
                @endif
                <div class="material-actions">
                    @if($material->file_path)
                    <a href="{{ asset($material->file_path) }}" target="_blank" class="action-btn view"><i class="fas fa-eye"></i> View</a>
                    @elseif($material->url)
                    <a href="{{ $material->url }}" target="_blank" class="action-btn visit"><i class="fas fa-external-link-alt"></i> Visit</a>
                    @endif
                    <a href="#" onclick="openEditModal({{ $material->id }})" class="action-btn edit"><i class="fas fa-edit"></i> Edit</a>
                    <form method="POST" action="{{ route('teacher.modules.delete', $material) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-btn delete"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="no-results">
                <i class="fas fa-search"></i>
                <h3>No Learning Materials Found</h3>
                <p>Try adjusting your filters or upload new materials.</p>
            </div>
            @endforelse
        </div>
    </main>
</div>

{{-- Upload Modal --}}
@include('teacher.partials.upload_modal')

{{-- Edit Modal --}}
@include('teacher.partials.edit_modal')

<script>
    function getTypeIcon(type) {
        switch (type) {
            case 'Module':
                return 'fas fa-book';
            case 'Presentation':
                return 'fas fa-chalkboard-teacher';
            case 'Video':
                return 'fas fa-video';
            case 'Image':
                return 'fas fa-image';
            case 'Website/Link':
                return 'fas fa-link';
            default:
                return 'fas fa-file';
        }
    }
</script>
@endsection