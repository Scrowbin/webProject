document.addEventListener('DOMContentLoaded', function () {
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    if (navbar) { // Add check to ensure navbar exists
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) { // Adjust scroll distance as needed
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // Sidebar toggle functionality
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const closeBtn = document.querySelector('#nav-sidebar .close-btn'); // Find close button within sidebar
    const bodyElement = document.body;
    const navbarBrand = document.querySelector('.navbar .navbar-brand'); // Only target navbar-brand in navbar

    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', () => {
            bodyElement.classList.add('sidebar-open'); // Use add, not toggle

            // Ensure elements are hidden immediately when sidebar opens
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
            bodyElement.classList.remove('sidebar-open'); // Close button removes the class

            // Show elements again when sidebar closes
            setTimeout(() => {
                hamburgerBtn.style.opacity = '';
                hamburgerBtn.style.visibility = '';
                if (navbarBrand) {
                    navbarBrand.style.opacity = '';
                    navbarBrand.style.visibility = '';
                }
            }, 300); // Match transition duration in CSS
        });
    }

    // User Modal functionality
    const userAvatarBtn = document.getElementById('user-avatar-btn');
    const userModalElement = document.getElementById('user-modal');

    if (userAvatarBtn && userModalElement) {
      const userModal = new bootstrap.Modal(userModalElement);

      userAvatarBtn.addEventListener('click', () => {
        userModal.show();
      });
    }
});