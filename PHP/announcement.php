<?php
  require('helper.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Announcement - MangaDax</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <link rel="stylesheet" href="../CSS/navbar.css">
  <link rel="stylesheet" href="../CSS/create.css">
  <!-- TinyMCE CDN with API Key -->
  <script src="https://cdn.tiny.cloud/1/j3bxzxkw8tsf9dq25jltesds0bwhorgiy845j6jmm5fjlsdb/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

</head>
<body>
  <?php include 'includes/navbar_minimal.php'; ?>
  <?php include 'includes/sidebar.php'; ?>

  <div class="container-xxl mt-5 pt-4">
    <h2 class="mb-4" id="title">Create Announcement</h2>

    <div class="row">
      <div class="col-lg-7">
        <form id="announcementForm" class="row g-3">
          <!-- Announcement Content -->
          <div class="col-12 mb-3">
            <label class="form-label">Announcement Content</label>
            <textarea class="form-control" name="content" id="content" rows="10"></textarea>
            <small class="form-text text-muted">This announcement will appear on the homepage and will deactivate all previous announcements.</small>
          </div>

          <!-- Expiration Date -->
          <div class="col-md-6">
            <label class="form-label">Expiration Date (Optional)</label>
            <input type="datetime-local" name="expire_at" class="form-control">
            <small class="form-text text-muted">Leave empty for no expiration</small>
          </div>

          <!-- Submit Button -->
          <div class="col-12 mt-4">
            <button type="submit" class="btn btn-primary">Post Announcement</button>
          </div>
        </form>
      </div>

      <div class="col-lg-5">
        <div class="card">
          <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Previous Announcements</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Content</th>
                    <th>Status</th>
                    <th>Expires</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (isset($announcements) && !empty($announcements)): ?>
                    <?php foreach ($announcements as $announcement): ?>
                      <tr>
                        <td><?= $announcement['announcementID'] ?></td>
                        <td>
                          <div style="max-width: 200px; max-height: 100px; overflow: hidden; text-overflow: ellipsis;">
                            <?= strip_tags($announcement['content']) ?>
                          </div>
                        </td>
                        <td>
                          <?php if ($announcement['isActive'] == 1): ?>
                            <span class="badge bg-success">Active</span>
                          <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php if ($announcement['expirteAt']): ?>
                            <?= date('Y-m-d H:i', strtotime($announcement['expirteAt'])) ?>
                          <?php else: ?>
                            <span class="text-muted">Never</span>
                          <?php endif; ?>
                          <?php if ($announcement['created_at']): ?>
                            <br>
                            <small class="text-muted">Posted <?= date('Y-m-d H:i', strtotime($announcement['created_at'])) ?></small>
                          <?php endif; ?>
                        </td>
                        <td>
                          <button class="btn btn-sm btn-danger delete-announcement" data-id="<?= $announcement['announcementID'] ?>">
                            <i class="bi bi-trash"></i> Delete
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="5" class="text-center">No announcements found</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <div class="alert alert-info mt-3">
              <i class="bi bi-info-circle-fill me-2"></i> Only the most recent active announcement will be displayed on the homepage.
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Announcement Preview -->
    <div id="announcementPreview" class="mt-4" style="display: none;">
      <div class="card border-success">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Preview: Your announcement will appear like this</h5>
          <button type="button" class="btn-close btn-close-white" aria-label="Close" onclick="document.getElementById('announcementPreview').style.display = 'none';"></button>
        </div>
        <div class="card-body">
          <div class="announcement-preview-container p-3" style="background-color: rgba(44, 62, 80, 0.85); color: #ecf0f1; border-radius: 5px;">
            <div class="announcement-preview-content"></div>
          </div>
          <div class="text-muted mt-2 small">
            <i class="bi bi-info-circle-fill"></i> This is how your announcement will appear on the homepage.
          </div>
        </div>
      </div>
    </div>

    <!-- Toast for feedback -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
      <div id="announcementToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
          <strong class="me-auto">Announcement</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="announcementToastBody">
          Announcement posted successfully!
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
    // Initialize TinyMCE
    tinymce.init({
      selector: '#content',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount advlist advtable autosave fullscreen help pagebreak preview save',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | fullscreen preview',
      height: 400,
      promotion: false, // Remove the TinyMCE promotion
      branding: false, // Remove TinyMCE branding
      menubar: 'file edit view insert format tools table help',
      content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 16px; }'
    });

    // Function to format relative time
    function getRelativeTimeString(date) {
      const now = new Date();
      const diffInSeconds = Math.floor((now - date) / 1000);

      if (diffInSeconds < 60) {
        return `${diffInSeconds} seconds ago`;
      }

      const diffInMinutes = Math.floor(diffInSeconds / 60);
      if (diffInMinutes < 60) {
        return `${diffInMinutes} minutes ago`;
      }

      const diffInHours = Math.floor(diffInMinutes / 60);
      if (diffInHours < 24) {
        return `${diffInHours} hours ago`;
      }

      const diffInDays = Math.floor(diffInHours / 24);
      if (diffInDays < 30) {
        return `${diffInDays} days ago`;
      }

      const diffInMonths = Math.floor(diffInDays / 30);
      if (diffInMonths < 12) {
        return `${diffInMonths} months ago`;
      }

      const diffInYears = Math.floor(diffInMonths / 12);
      return `${diffInYears} years ago`;
    }

    // Function to refresh the announcements table
    function refreshAnnouncementsTable() {
      fetch('../controller/get_announcements.php')
        .then(response => {
          if (!response.ok) {
            throw new Error("Failed to fetch announcements");
          }
          return response.json();
        })
        .then(data => {
          const tableBody = document.querySelector('table.table tbody');
          if (!tableBody) return;

          if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No announcements found</td></tr>';
            return;
          }

          let html = '';
          data.forEach(announcement => {
            const content = announcement.content ? announcement.content.replace(/<[^>]*>/g, '') : '';
            const truncatedContent = content.length > 100 ? content.substring(0, 100) + '...' : content;
            const statusBadge = announcement.isActive == 1
              ? '<span class="badge bg-success">Active</span>'
              : '<span class="badge bg-secondary">Inactive</span>';

            let expiresText = '<span class="text-muted">Never</span>';
            if (announcement.expirteAt) {
              const date = new Date(announcement.expirteAt);
              expiresText = date.toLocaleString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
              });
            }

            // Format created time
            const createdDate = new Date(announcement.created_at || announcement.createdAt || Date.now());
            const createdTime = getRelativeTimeString(createdDate);

            html += `
              <tr>
                <td>${announcement.announcementID}</td>
                <td>
                  <div style="max-width: 200px; max-height: 100px; overflow: hidden; text-overflow: ellipsis;">
                    ${truncatedContent}
                  </div>
                </td>
                <td>${statusBadge}</td>
                <td>
                  <div>${expiresText}</div>
                  <small class="text-muted">Posted ${createdTime}</small>
                </td>
                <td>
                  <button class="btn btn-sm btn-danger delete-announcement" data-id="${announcement.announcementID}">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                </td>
              </tr>
            `;
          });

          tableBody.innerHTML = html;

          // Add a subtle highlight effect to the first row (newest announcement)
          const firstRow = tableBody.querySelector('tr:first-child');
          if (firstRow) {
            firstRow.classList.add('table-primary');
            setTimeout(() => {
              firstRow.classList.remove('table-primary');
            }, 3000);
          }
        })
        .catch(error => {
          console.error("Error refreshing announcements:", error);
        });
    }

    // Initial load of announcements table
    refreshAnnouncementsTable();

    // Handle delete announcement
    document.addEventListener('click', function(e) {
      if (e.target.closest('.delete-announcement')) {
        const button = e.target.closest('.delete-announcement');
        const announcementId = button.getAttribute('data-id');

        if (confirm('Are you sure you want to delete this announcement?')) {
          // Disable the button to prevent multiple clicks
          button.disabled = true;
          button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...';

          // Send delete request
          fetch('../controller/delete_announcement.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ announcementID: announcementId })
          })
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            if (data.success) {
              // Show success message
              const toastBody = document.getElementById('announcementToastBody');
              toastBody.textContent = 'Announcement deleted successfully!';
              const toast = new bootstrap.Toast(document.getElementById('announcementToast'));
              toast.show();

              // Refresh the announcements table
              refreshAnnouncementsTable();
            } else {
              throw new Error(data.error || 'Failed to delete announcement');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            // Show error message
            const toastBody = document.getElementById('announcementToastBody');
            toastBody.textContent = `Error: ${error.message}`;
            const toast = new bootstrap.Toast(document.getElementById('announcementToast'));
            toast.show();

            // Re-enable the button
            button.disabled = false;
            button.innerHTML = '<i class="bi bi-trash"></i> Delete';
          });
        }
      }
    });

    // Handle form submission
    document.getElementById('announcementForm').addEventListener('submit', function(e) {
      e.preventDefault(); // Prevent default form submission
      const form = e.target;
      const formData = new FormData(form);
      const submitButton = form.querySelector('button[type="submit"]');

      // Disable submit button and show loading state
      if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Posting...';
      }

      // Get content from TinyMCE and add it to the form data
      if (tinymce.get('content')) {
        formData.set('content', tinymce.get('content').getContent());
      }

      const toastBody = document.getElementById('announcementToastBody');

      fetch('../controller/handle_announcement.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error("Network response was not OK");
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          toastBody.textContent = data.message;
          form.reset();

          // Reset TinyMCE editor
          if (tinymce.get('content')) {
            tinymce.get('content').setContent('');
          }

          // Refresh the announcements table to show the new announcement
          refreshAnnouncementsTable();

          // Show a preview of the announcement on the page
          const previewContainer = document.getElementById('announcementPreview');
          if (previewContainer) {
            previewContainer.style.display = 'block';
            previewContainer.querySelector('.announcement-preview-content').innerHTML = formData.get('content');

            // Auto-hide preview after 5 seconds
            setTimeout(() => {
              previewContainer.style.display = 'none';
            }, 5000);
          }
        } else {
          toastBody.textContent = `Error: ${data.error}`;
        }

        // Show toast notification
        const toast = new bootstrap.Toast(document.getElementById('announcementToast'));
        toast.show();

        // Re-enable submit button
        if (submitButton) {
          submitButton.disabled = false;
          submitButton.innerHTML = 'Post Announcement';
        }
      })
      .catch(error => {
        console.error("Error posting announcement:", error);
        toastBody.textContent = `Posting failed: ${error.message}`;

        // Show toast notification
        const toast = new bootstrap.Toast(document.getElementById('announcementToast'));
        toast.show();

        // Re-enable submit button
        if (submitButton) {
          submitButton.disabled = false;
          submitButton.innerHTML = 'Post Announcement';
        }
      });
    });
  });
  </script>
</body>
</html>
