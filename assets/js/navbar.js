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