/**
 * Homepage Announcements - Real-time updates using AJAX
 * This script handles fetching and displaying announcements on the homepage
 */

document.addEventListener('DOMContentLoaded', function() {
  // Reference to the announcement overlay
  const announcementOverlay = document.getElementById('announcement-overlay');

  // Get the current announcement ID from sessionStorage
  const currentAnnouncementId = sessionStorage.getItem('currentAnnouncementId');

  // Get the dismissed status from sessionStorage
  const announcementDismissed = sessionStorage.getItem('announcementDismissed') === 'true';

  // Function to check for new announcements
  function checkForNewAnnouncements() {
    // If the user has dismissed the announcement, don't show it again in this session
    if (announcementDismissed) {
      return;
    }

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

          // Check if this is a new announcement or if we haven't shown any yet
          const isNewAnnouncement = currentAnnouncementId !== announcement.announcementID.toString();

          if (isNewAnnouncement && !announcementDismissed) {
            // Update the current announcement ID in sessionStorage
            sessionStorage.setItem('currentAnnouncementId', announcement.announcementID);

            // Update the announcement content
            const contentContainer = announcementOverlay.querySelector('.announcement-content');
            if (contentContainer) {
              contentContainer.innerHTML = announcement.content;
            }

            // Show the announcement
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
      // Hide the announcement
      announcementOverlay.style.display = 'none';

      // Mark as dismissed in this session
      sessionStorage.setItem('announcementDismissed', 'true');
    });
  }

  // Initial check for announcements with a slight delay
  setTimeout(checkForNewAnnouncements, 1500);
});
