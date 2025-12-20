document.addEventListener('DOMContentLoaded', function() {
    const progressFills = document.querySelectorAll('.progress-fill');

    progressFills.forEach(bar => {
        // Get computed width
        const computedWidth = getComputedStyle(bar).width;

        // Convert to percentage if needed (optional, depends on CSS)
        const parentWidth = bar.parentElement.offsetWidth;
        const widthPercent = (parseFloat(computedWidth) / parentWidth) * 100 + '%';

        // Start from 0
        bar.style.width = '0%';

        // Animate to actual width
        setTimeout(() => {
            bar.style.transition = 'width 1s ease-in-out';
            bar.style.width = widthPercent;
        }, 100);
    });
});
