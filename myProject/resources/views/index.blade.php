<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MathQuest | Mapaniqui Elementary Grade 3</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet"> {{-- Laravel Assets --}}
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
</head>

<body>
    <header>
        <div class="container nav-container">
            <div class="logo">
                <div class="logo-icon"> <i class="fas fa-gamepad"></i> </div>
                <div class="logo-text">MathQuest</div>
            </div>
            <nav class="nav-links"> <a href="#Home">Home</a> <a href="#About">About</a> <a href="#Contact">Contact
                    Us</a> </nav> <a href="{{ route('login') }}" class="login-icon-btn" title="Login"> <i
                    class="fas fa-user"></i> </a>
        </div>
    </header>
    <section class="hero" id="Home">
        <div class="hero-bg"></div>
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="container">
            <h1><span class="floating">Math Quest</span> Teacher Portal</h1>
            <p class="hero-subtitle"> A gamified learning platform designed for Grade 3 students at Mapaniqui Elementary
                School. Transform mathematics into an exciting adventure with interactive quizzes, levels and badge
                rewards! </p>
            <div class="hero-buttons"> <a href="{{ route('login') }}" class="primary-btn pulse"> <i
                        class="fas fa-play-circle"></i> Log In </a> <a href="{{ route('register') }}"
                    class="secondary-btn"> <i class="fas fa-user-plus"></i> Sign Up </a> </div>
            <div class="school-badge">
                <div class="badge-icon"> <img src="{{ asset('assets/imgs/logo.png') }}" alt="School Logo"> </div>
                <div>
                    <h3 style="color: var(--dark-text);">Mapaniqui Elementary School</h3>
                    <p style="color: var(--muted-text);"> Designed in collaboration with<br>Grade 3 mathematics teachers
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="features" id="About">
        <div class="container">
            <h2 class="section-title">About <span>MathQuest</span> System</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-layer-group"></i></div>
                    <h3>Levels</h3>
                    <p> Students earn points from completing quizzes. Students start at Level 1 and can reach up to
                        Level 50. This motivates students towards consistent learning and progress. </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-award"></i></div>
                    <h3>Badges</h3>
                    <p> Students earn badges after achieving milestones from quiz challenges and leveling up. This
                        encourages engagement and celebrates learning achievements. </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-question-circle"></i></div>
                    <h3>Interactive Quizzes</h3>
                    <p> Teachers can create and assign quizzes for each section. Quiz difficulty adapts to each
                        student's learning speed and performance. </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-folder-open"></i></div>
                    <h3>Learning Materials</h3>
                    <p> Teachers upload learning materials including modules, videos, images, and links. Weekly
                        materials are highlighted for students. </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-child"></i></div>
                    <h3>Progress Tracking</h3>
                    <p> Teachers can monitor student profiles including levels, badges, quiz history, and learner
                        categories for easy tracking. </p>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container" id="Contact">
            <div class="footer-content">
                <div style="text-align:center;">
                    <div class="logo" style="margin-bottom:20px;">
                        <div class="logo-icon" style="color:white;"><i class="fas fa-gamepad"></i></div>
                        <div class="logo-text">MathQuest</div>
                    </div>
                    <p style="color:#CBD5E0;"> Gamified mathematics education platform for<br> Grade 3 students of
                        Mapaniqui Elementary School. </p>
                </div>
                <div>
                    <h3 class="footer-heading">Contact Us</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> Pulong Balon, Mapaniqui, Candaba, Pampanga</li>
                        <li><i class="fas fa-envelope"></i> 105940@deped.gov.ph</li>
                        <li> <i class="fab fa-facebook"></i> <a
                                href="https://www.facebook.com/mapaniquies">facebook.com/mapaniquies</a> </li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>MathQuest © 2025 | Mapaniqui Elementary School</p>
            </div>
        </div>
    </footer>
    <script src="{{ asset('assets/js/index.js') }}"></script>
</body>

</html>