/**
 * Announcement functionality for MangaDax
 * Handles displaying, hiding, and animating announcements
 */
document.addEventListener('DOMContentLoaded', function() {
  // Get the announcement overlay
  var announcementOverlay = document.getElementById('announcement-overlay');

  // Only show announcement if there's actual content in it
  if (announcementOverlay) {
    const contentContainer = announcementOverlay.querySelector('.announcement-content');
    // Check if there's any content in the announcement
    if (contentContainer && contentContainer.innerHTML.trim() !== '') {
      // Show announcement with a slight delay for better user experience
      setTimeout(function() {
        announcementOverlay.style.display = 'block';
      }, 1500);

      // Auto-hide announcement after 30 seconds
      setTimeout(function() {
        announcementOverlay.style.display = 'none';
      }, 30000); // 30 seconds
    }
  }

  // Close button functionality
  var closeButton = document.getElementById('announcement-close');
  if (closeButton) {
    closeButton.addEventListener('click', function() {
      document.getElementById('announcement-overlay').style.display = 'none';
    });
  }
});
