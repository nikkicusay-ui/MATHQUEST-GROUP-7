<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'MathQuest')</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/teacher/quizzes.css') }}">
    @stack('styles')
</head>
<body>
    <div class="container">
        @include('teacher.layouts.sidebar')
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('assets/js/teacher/sidebar.js') }}"></script>
    <script src="{{ asset('assets/js/teacher/quizzes.js') }}"></script>
    @stack('scripts')
</body>
</html>
