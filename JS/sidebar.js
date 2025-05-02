/**
 * Sidebar Functionality
 * This script handles the sidebar behavior and its effect on page content
 */
document.addEventListener('DOMContentLoaded', function () {
    // Sidebar elements
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const closeBtn = document.querySelector('#nav-sidebar .close-btn');
    const bodyElement = document.body;
    const navbarBrand = document.querySelector('.navbar .navbar-brand');

    // Toggle sidebar open
    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', () => {
            bodyElement.classList.add('sidebar-open');

            // Hide hamburger and navbar brand
            hamburgerBtn.style.opacity = '0';
            hamburgerBtn.style.visibility = 'hidden';
            if (navbarBrand) {
                navbarBrand.style.opacity = '0';
                navbarBrand.style.visibility = 'hidden';
            }

            // Adjust content width and position
            adjustContentForSidebar(true);
        });
    }

    // Toggle sidebar close
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            bodyElement.classList.remove('sidebar-open');

            // Reset content width and position
            adjustContentForSidebar(false);

            // Show elements again when sidebar closes (with delay to match transition)
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

    // Handle window resize events
    window.addEventListener('resize', function() {
        adjustContentForSidebar(bodyElement.classList.contains('sidebar-open'));
    });

    // Initial call to set correct state
    adjustContentForSidebar(bodyElement.classList.contains('sidebar-open'));

    /**
     * Adjusts the content layout based on sidebar state
     * @param {boolean} isSidebarOpen - Whether the sidebar is open or not
     */
    function adjustContentForSidebar(isSidebarOpen) {
        // Regular content elements
        const regularContent = document.querySelectorAll('.page-wrapper, .container-xxl, .container-fluid, main');
        
        // Special handling for the Popular New Titles section
        const popularNewTitlesSection = document.querySelector('.popular-new-titles-section.full-width-section');
        const popularNewTitlesContainer = popularNewTitlesSection ? 
            popularNewTitlesSection.querySelector('.container-xxl') : null;

        if (isSidebarOpen) {
            // Adjust regular content elements
            regularContent.forEach(element => {
                if (element && !element.closest('.popular-new-titles-section')) {
                    element.style.transform = 'translateX(280px)';
                    element.style.width = 'calc(100% - 280px)';
                }
            });

            // Special handling for Popular New Titles section
            if (popularNewTitlesSection) {
                popularNewTitlesSection.style.transform = 'translateX(280px)';
                popularNewTitlesSection.style.width = '100%';
                
                if (popularNewTitlesContainer) {
                    popularNewTitlesContainer.style.width = 'calc(100% - 280px)';
                }
            }
        } else {
            // Reset all elements when sidebar is closed
            regularContent.forEach(element => {
                if (element) {
                    element.style.transform = '';
                    element.style.width = '';
                }
            });

            // Reset Popular New Titles section
            if (popularNewTitlesSection) {
                popularNewTitlesSection.style.transform = '';
                popularNewTitlesSection.style.width = '';
                
                if (popularNewTitlesContainer) {
                    popularNewTitlesContainer.style.width = '';
                }
            }
        }
    }
}); 