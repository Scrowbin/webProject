document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Handle tab switching
    var tabLinks = document.querySelectorAll('#profileTabs .nav-link');
    tabLinks.forEach(function(tabLink) {
        tabLink.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs
            tabLinks.forEach(function(link) {
                link.classList.remove('active');
            });
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Show corresponding tab content
            var targetId = this.getAttribute('data-bs-target').substring(1);
            var tabContents = document.querySelectorAll('.tab-pane');
            tabContents.forEach(function(content) {
                content.classList.remove('show', 'active');
                if (content.id === targetId) {
                    content.classList.add('show', 'active');
                }
            });
        });
    });
    
    // Handle edit profile banner button
    var editBannerBtn = document.querySelector('.profile-actions button:last-child');
    if (editBannerBtn) {
        editBannerBtn.addEventListener('click', function() {
            // Redirect to profile settings page
            window.location.href = '../controller/auth_controller.php?action=profile_settings';
        });
    }
});
