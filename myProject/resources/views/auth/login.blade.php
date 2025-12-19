<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login | MathQuest</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="top-logo-container">
        <a href="{{ route('home') }}" class="logo-link">
            <div class="logo-icon">
                <i class="fas fa-gamepad"></i>
            </div>
            <div class="logo-text">MATHQUEST</div>
        </a>
    </div>

    <div class="modal-container">
        <!-- Login Form -->
        <div id="login-form">
            <div class="modal-header">
                <h2>Welcome Teacher!</h2>
                <p>Sign in to your MathQuest Teacher Portal</p>
            </div>

            <div class="modal-body">
                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="input-group">
                            <input type="email" name="email" id="login-identifier" class="form-input" 
                                   placeholder="Enter your email" required value="{{ old('email') }}">
                            <i class="fas fa-envelope input-icon" style="cursor: default; pointer-events: none;"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="login-password" class="form-input" 
                                   placeholder="Enter your password" required>
                            <button type="button" class="input-icon" id="toggle-login-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember_me" id="remember-me" {{ old('remember_me') ? 'checked' : '' }}>
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="forgot-link" id="forgot-password">Forgot password?</a>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>

                    <div class="register-link">
                        Don't have an account? <a href="{{ route('signup') }}" class="signup-link">Sign Up</a>
                    </div>

                    <div class="back-btn-container">
                        <a href="{{ route('home') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>
                    </div>

                    <div class="form-footer">
                        <p>MathQuest © {{ date('Y') }} | Mapaniqui Elementary School</p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Forgot Password Form (Hidden by default) -->
        <div id="forgot-form" style="display: none;">
            <div class="modal-header">
                <h2>Reset Password</h2>
                <p>Enter your email to receive reset instructions</p>
            </div>

            <div class="modal-body">
                <div class="alert" id="forgot-alert" style="display: none;"></div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <input type="email" id="forgot-email" class="form-input" 
                               placeholder="Enter your registered email" required>
                        <i class="fas fa-envelope input-icon" style="cursor: default; pointer-events: none;"></i>
                    </div>
                </div>

                <button type="button" class="submit-btn" id="reset-btn">
                    <i class="fas fa-paper-plane"></i> Send Reset Link
                </button>

                <div class="register-link">
                    <a href="#" id="back-to-login">Back to Sign In</a>
                </div>

                <div class="form-footer">
                    <p>MathQuest © {{ date('Y') }} | Mapaniqui Elementary School</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Toggle password visibility
            const togglePasswordButton = document.getElementById('toggle-login-password');
            const passwordInput = document.getElementById('login-password');
            
            if (togglePasswordButton && passwordInput) {
                togglePasswordButton.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }

            // Form Toggle Logic
            const loginForm = document.getElementById('login-form');
            const forgotForm = document.getElementById('forgot-form');
            const forgotPasswordLink = document.getElementById('forgot-password');
            const backToLoginLink = document.getElementById('back-to-login');
            const forgotAlert = document.getElementById('forgot-alert');

            // Show forgot password form
            if (forgotPasswordLink) {
                forgotPasswordLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    loginForm.style.display = 'none';
                    forgotForm.style.display = 'block';
                    forgotAlert.style.display = 'none';
                });
            }

            // Show login form
            if (backToLoginLink) {
                backToLoginLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    forgotForm.style.display = 'none';
                    loginForm.style.display = 'block';
                });
            }

            // Handle reset password
            const resetBtn = document.getElementById('reset-btn');
            const forgotEmailInput = document.getElementById('forgot-email');

            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    const email = forgotEmailInput.value.trim();
                    
                    if (!email) {
                        showAlert('Please enter your email address.', 'error');
                        return;
                    }

                    if (!validateEmail(email)) {
                        showAlert('Please enter a valid email address.', 'error');
                        return;
                    }

                    // Show loading state
                    const originalText = resetBtn.innerHTML;
                    resetBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                    resetBtn.disabled = true;

                    // Send AJAX request
                    fetch('{{ route("teacher.password.reset") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ email: email })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showAlert(data.message, 'success');
                            forgotEmailInput.value = '';
                            
                            // Auto-redirect to login after 3 seconds
                            setTimeout(() => {
                                forgotForm.style.display = 'none';
                                loginForm.style.display = 'block';
                                forgotAlert.style.display = 'none';
                            }, 3000);
                        } else {
                            showAlert(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('An error occurred. Please try again.', 'error');
                    })
                    .finally(() => {
                        // Restore button state
                        resetBtn.innerHTML = originalText;
                        resetBtn.disabled = false;
                    });
                });
            }

            // Helper function to show alert
            function showAlert(message, type, show = true) {
                if (!forgotAlert) return;
                
                forgotAlert.textContent = message;
                forgotAlert.className = 'alert';
                
                if (type === 'success') {
                    forgotAlert.classList.add('alert-success');
                } else if (type === 'error') {
                    forgotAlert.classList.add('alert-error');
                }
                
                forgotAlert.style.display = show ? 'block' : 'none';
            }

            // Email validation
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            // Auto-focus on email input when forgot form is shown
            if (forgotPasswordLink && forgotEmailInput) {
                forgotPasswordLink.addEventListener('click', function() {
                    setTimeout(() => {
                        forgotEmailInput.focus();
                    }, 100);
                });
            }
        });
    </script>
</body>
</html>