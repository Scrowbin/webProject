document.addEventListener('DOMContentLoaded', function() {
    // Get all view buttons
    const viewButtons = document.querySelectorAll('.view-btn');
    const container = document.querySelector('.container-xxl');

    // Set default view to list view
    container.classList.add('list-view-active');

    // Add click event to each button
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            viewButtons.forEach(btn => btn.classList.remove('active'));

            // Add active class to clicked button
            this.classList.add('active');

            // Get view type from button class
            const viewType = this.classList.contains('list-view') ? 'list' :
                            this.classList.contains('grid-view') ? 'grid' : 'compact';

            // Apply view type to container
            container.classList.remove('list-view-active', 'grid-view-active', 'compact-view-active');
            container.classList.add(`${viewType}-view-active`);

            // Save preference to localStorage
            localStorage.setItem('libraryViewPreference', viewType);
        });
    });

    // Load saved preference if exists
    const savedView = localStorage.getItem('libraryViewPreference');
    if (savedView) {
        const buttonToActivate = document.querySelector(`.${savedView}-view`);
        if (buttonToActivate) {
            buttonToActivate.click();
        }
    } else {
        // If no preference is saved, default to list view
        document.querySelector('.list-view').classList.add('active');
    }
});
