/**
 * Sidebar functionality for MangaDax
 * This file consolidates all sidebar-related JavaScript functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle functionality
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const closeBtn = document.querySelector('#nav-sidebar .close-btn');
    const bodyElement = document.body;
    const navbarBrand = document.querySelector('.navbar .navbar-brand');

    // Toggle sidebar open/close
    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', () => {
            bodyElement.classList.add('sidebar-open');

            // Hide navbar elements when sidebar opens
            hamburgerBtn.style.opacity = '0';
            hamburgerBtn.style.visibility = 'hidden';
            if (navbarBrand) {
                navbarBrand.style.opacity = '0';
                navbarBrand.style.visibility = 'hidden';
            }
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            bodyElement.classList.remove('sidebar-open');

            // Show navbar elements after sidebar closes (with delay to match transition)
            setTimeout(() => {
                hamburgerBtn.style.opacity = '';
                hamburgerBtn.style.visibility = '';
                if (navbarBrand) {
                    navbarBrand.style.opacity = '';
                    navbarBrand.style.visibility = '';
                }
            }, 300);
        });
    }

    // Handle section highlighting
    // Note: Only the Titles section is clickable (handled by CSS)
    // For other sections, we just need to highlight them if their children are active
    const sidebarSections = document.querySelectorAll('.sidebar-section');

    sidebarSections.forEach(section => {
        const sectionTitle = section.querySelector('.section-title');
        const subLinks = section.querySelectorAll('.sub-links .nav-link');

        // Check if any sub-links are active
        const hasActiveChild = Array.from(subLinks).some(link => link.classList.contains('active'));

        // If any sub-link is active, highlight the section title
        if (hasActiveChild && sectionTitle) {
            sectionTitle.style.color = '#FF6740';
        }
    });
});
