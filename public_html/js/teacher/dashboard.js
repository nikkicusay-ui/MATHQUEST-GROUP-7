document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    // Initialize progress bar animation
    const progressFill = document.getElementById('class-performance');
    if (progressFill) {
        // Get the width from the inline style
        const width = progressFill.style.width;
        // Set initial width to 0
        progressFill.style.width = '0%';
        
        // Animate to the target width
        setTimeout(() => {
            progressFill.style.width = width;
        }, 300);
    }
    
    // Logout confirmation
    const logoutForm = document.querySelector('.logout-form');
    if (logoutForm) {
        logoutForm.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to logout?')) {
                e.preventDefault();
            }
        });
    }
    
    // Update welcome message based on time of day
    const welcomeMessage = document.getElementById('welcome-message');
    if (welcomeMessage) {
        const hour = new Date().getHours();
        let greeting = '';
        
        if (hour < 12) {
            greeting = 'Good Morning';
        } else if (hour < 18) {
            greeting = 'Good Afternoon';
        } else {
            greeting = 'Good Evening';
        }
        
        welcomeMessage.textContent = `${greeting}! Teacher Dashboard - Manage Your Math Classes`;
    }
});