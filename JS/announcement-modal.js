/**
 * Announcement Modal - Handles the new announcement modal display
 */
document.addEventListener('DOMContentLoaded', function() {
  // References to modal elements
  const announcementModal = document.getElementById('announcement-modal');
  const announcementBackdrop = document.getElementById('announcement-backdrop');
  const announcementContent = document.getElementById('announcement-modal-content');
  const btnHide = document.getElementById('btn-hide');
  const navbarAnnouncementIndicator = document.getElementById('navbar-announcement-indicator');

  // References to announcement list modal elements
  const announcementListModal = document.getElementById('announcement-list-modal');
  const announcementListContent = document.getElementById('announcement-list-content');
  const announcementListClose = document.getElementById('announcement-list-close');

  // Get the current announcement ID from localStorage (changed from sessionStorage for persistence)
  const currentAnnouncementId = localStorage.getItem('currentAnnouncementId');

  // Get the hidden announcements from localStorage
  const hiddenAnnouncements = JSON.parse(localStorage.getItem('hiddenAnnouncements') || '[]');

  // Function to show the announcement modal
  function showAnnouncementModal(announcement) {
    if (announcementContent) {
      announcementContent.innerHTML = announcement.content;
    }

    if (announcementModal) {
      announcementModal.style.display = 'block';
    }
  }

  // Function to hide the announcement modal
  function hideAnnouncementModal() {
    if (announcementModal) {
      announcementModal.style.display = 'none';
    }
  }

  // Function to show the navbar indicator dot
  function showNavbarIndicator() {
    if (navbarAnnouncementIndicator) {
      const indicatorDot = navbarAnnouncementIndicator.querySelector('.indicator-dot');
      if (indicatorDot) {
        indicatorDot.style.display = 'block';
      }
    }
  }

  // Function to hide the navbar indicator dot
  function hideNavbarIndicator() {
    if (navbarAnnouncementIndicator) {
      const indicatorDot = navbarAnnouncementIndicator.querySelector('.indicator-dot');
      if (indicatorDot) {
        indicatorDot.style.display = 'none';
      }
    }
  }

  // Function to show the announcement list modal
  function showAnnouncementListModal() {
    if (announcementListModal) {
      // Position the modal relative to the megaphone icon
      positionAnnouncementListModal();

      // Fetch recent announcements
      fetch('controller/get_recent_announcements.php')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if (data.success && data.announcements && data.announcements.length > 0) {
            // Clear existing content
            announcementListContent.innerHTML = '';

            // Add each announcement to the list
            data.announcements.forEach(announcement => {
              const item = document.createElement('div');
              item.className = 'announcement-list-item';

              // Format the date
              const date = new Date(announcement.createdAt || Date.now());
              const formattedDate = date.toLocaleString();

              // Create a preview of the content (strip HTML and limit length)
              const tempDiv = document.createElement('div');
              tempDiv.innerHTML = announcement.content;
              const textContent = tempDiv.textContent || tempDiv.innerText || '';
              const contentPreview = textContent.substring(0, 150) + (textContent.length > 150 ? '...' : '');

              item.innerHTML = `
                <div class="announcement-list-item-time">${formattedDate}</div>
                <div class="announcement-list-item-content">${contentPreview}</div>
              `;

              // Add click event to show the full announcement
              item.addEventListener('click', function() {
                showAnnouncementModal(announcement);
                hideAnnouncementListModal();
              });

              announcementListContent.appendChild(item);
            });

            // Show the modal
            announcementListModal.style.display = 'block';
          }
        })
        .catch(error => {
          console.error('Error fetching recent announcements:', error);
        });
    }
  }

  // Function to position the announcement list modal below the megaphone icon
  function positionAnnouncementListModal() {
    if (navbarAnnouncementIndicator && announcementListModal) {
      // Get the position of the megaphone icon
      const rect = navbarAnnouncementIndicator.getBoundingClientRect();

      // Position the modal below the icon
      // We're using CSS for most positioning, but we can fine-tune if needed
      // This is a fallback in case the CSS positioning needs adjustment
      if (window.innerWidth <= 768) {
        // For mobile, center it more
        announcementListModal.style.right = '10px';
      }
    }
  }

  // Function to hide the announcement list modal
  function hideAnnouncementListModal() {
    if (announcementListModal) {
      announcementListModal.style.display = 'none';
    }
  }

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

          // Check if this is a new announcement or if we haven't shown any yet
          const isNewAnnouncement = currentAnnouncementId !== announcement.announcementID.toString();

          // Check if this announcement is in the hidden list
          const isHidden = hiddenAnnouncements.includes(announcement.announcementID.toString());

          // Always show the indicator if there's an announcement
          showNavbarIndicator();

          // Only show the modal if it's a new announcement and not hidden
          if (isNewAnnouncement && !isHidden) {
            // Update the current announcement ID in localStorage
            localStorage.setItem('currentAnnouncementId', announcement.announcementID);

            // Only show if there's actual content
            if (announcement.content && announcement.content.trim() !== '') {
              // Show the modal
              showAnnouncementModal(announcement);
            }
          }
        }
      })
      .catch(error => {
        console.error('Error checking for announcements:', error);
      });
  }

  // Event listener for hide button
  if (btnHide) {
    btnHide.addEventListener('click', function() {
      // Hide the modal
      hideAnnouncementModal();

      // Get the current announcement ID
      const announcementId = localStorage.getItem('currentAnnouncementId');

      // Add to hidden announcements list
      if (announcementId) {
        const hiddenList = JSON.parse(localStorage.getItem('hiddenAnnouncements') || '[]');
        if (!hiddenList.includes(announcementId)) {
          hiddenList.push(announcementId);
          localStorage.setItem('hiddenAnnouncements', JSON.stringify(hiddenList));
        }
      }
    });
  }

  // Event listener for navbar indicator
  if (navbarAnnouncementIndicator) {
    navbarAnnouncementIndicator.addEventListener('click', function() {
      // Show the announcement list modal
      showAnnouncementListModal();
    });
  }

  // Event listener for announcement list close button
  if (announcementListClose) {
    announcementListClose.addEventListener('click', function() {
      hideAnnouncementListModal();
    });
  }

  // Initial check for announcements with a slight delay
  setTimeout(checkForNewAnnouncements, 1500);
});
