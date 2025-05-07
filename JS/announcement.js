/**
 * Announcement functionality for MangaDax
 * Handles displaying, hiding, and animating announcements
 */
document.addEventListener('DOMContentLoaded', function() {
  // Show announcement with a slight delay for better user experience
  setTimeout(function() {
    var announcementOverlay = document.getElementById('announcement-overlay');
    if (announcementOverlay) {
      announcementOverlay.style.display = 'block';
    }
  }, 1500);
  
  // Close button functionality
  var closeButton = document.getElementById('announcement-close');
  if (closeButton) {
    closeButton.addEventListener('click', function() {
      document.getElementById('announcement-overlay').style.display = 'none';
    });
  }
  
  // Auto-hide announcement after 30 seconds
  setTimeout(function() {
    var announcementOverlay = document.getElementById('announcement-overlay');
    if (announcementOverlay) {
      announcementOverlay.style.display = 'none';
    }
  }, 30000); // 30 seconds
});
