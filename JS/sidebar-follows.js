/**
 * This script handles the highlighting of the Follows section title
 * when one of its child links is active.
 */
document.addEventListener('DOMContentLoaded', function() {
    // Find all sub-links under the Follows section
    const followsSection = document.querySelector('.sidebar-section [data-section="follows"]');
    
    if (followsSection) {
        const parentSection = followsSection.closest('.sidebar-section');
        const subLinks = parentSection.querySelectorAll('.sub-links .nav-link');
        
        // Check if any of the sub-links are active
        let hasActiveChild = false;
        subLinks.forEach(link => {
            if (link.classList.contains('active')) {
                hasActiveChild = true;
            }
        });
        
        // If any sub-link is active, highlight the Follows section title
        if (hasActiveChild) {
            followsSection.style.color = '#FF6740';
        }
    }
});
