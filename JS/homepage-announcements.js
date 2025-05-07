/**
 * Homepage Announcements - Real-time updates using AJAX
 * This script handles fetching and displaying announcements on the homepage
 */

document.addEventListener('DOMContentLoaded', function() {
  // Check for new announcements every 30 seconds
  const ANNOUNCEMENT_CHECK_INTERVAL = 30000; // 30 seconds
  
  // Reference to the announcement overlay
  const announcementOverlay = document.getElementById('announcement-overlay');
  
  // Function to check for new announcements
  function checkForNewAnnouncements() {
    fetch('controller/get_latest_announcement.php')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        if (data.success && data.hasAnnouncement) {
          // If there's a new announcement
          const announcement = data.announcement;
          
          // Update the announcement content
          const contentContainer = announcementOverlay.querySelector('.announcement-content');
          if (contentContainer) {
            contentContainer.innerHTML = announcement.content;
          }
          
          // Show the announcement if it's not already visible
          if (announcementOverlay.style.display !== 'block') {
            announcementOverlay.style.display = 'block';
            
            // Auto-hide after 30 seconds
            setTimeout(function() {
              announcementOverlay.style.display = 'none';
            }, 30000);
          }
        }
      })
      .catch(error => {
        console.error('Error checking for announcements:', error);
      });
  }
  
  // Close button functionality
  const closeButton = document.getElementById('announcement-close');
  if (closeButton) {
    closeButton.addEventListener('click', function() {
      announcementOverlay.style.display = 'none';
    });
  }
  
  // Initial check for announcements with a slight delay
  setTimeout(checkForNewAnnouncements, 1500);
  
  // Set up periodic checks for new announcements
  setInterval(checkForNewAnnouncements, ANNOUNCEMENT_CHECK_INTERVAL);
});
