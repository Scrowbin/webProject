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

    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', () => {
            bodyElement.classList.add('sidebar-open'); // Use add, not toggle
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            bodyElement.classList.remove('sidebar-open'); // Close button removes the class
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