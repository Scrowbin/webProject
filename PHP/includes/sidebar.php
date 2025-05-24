<aside id="nav-sidebar">
  <div class="sidebar-header">
  <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="/index.php">
       <?php // Corrected path for logo ?>
       <img src="/IMG/logo.png" alt="Logo" style="height: 30px; margin-right: 8px;">
       MangaDax
    </a>
    <button class="btn text-white close-btn" type="button">
      <i class="bi bi-x-lg fs-4"></i>
    </button>
  </div>
  <nav class="sidebar-nav">
      <!-- Home as a standalone section -->
      <a href="/index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>"><i class="bi bi-house-door-fill"></i> <span>Home</span></a>

      <!-- Follows section with subsections -->
      <div class="sidebar-section">
          <div class="nav-link section-title" data-section="follows" tabindex="-1" aria-label="Follows section"><i class="bi bi-bookmark-fill"></i> <span>Follows</span></div>
          <div class="sub-links">
              <a href="/my-follows" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'follows.php' || (isset($isFollows) && $isFollows) ? 'active' : '' ?>">Updates</a>
              <a href="/library" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'library.php' || (isset($isLibrary) && $isLibrary) ? 'active' : '' ?>">Library</a>
              <a href="/reading-history" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'readingHistory_controller.php' || (isset($isReadingHistory) && $isReadingHistory) ? 'active' : '' ?>">Reading History</a>
          </div>
      </div>

      <!-- Titles section (unchanged) -->
      <div class="sidebar-section">
          <a href="/admin/add-manga" class="nav-link section-title" data-section="titles"><i class="bi bi-book-fill"></i> <span>Titles</span> <i class="bi bi-plus-lg float-end"></i></a>
          <div class="sub-links">
              <a href="/search" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'advanced_search.php' || (isset($isAdvancedSearch) && $isAdvancedSearch) ? 'active' : '' ?>">Advanced Search</a>
              <a href="/recently-added" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'recently_added_controller.php' || (isset($isRecentlyAdded) && $isRecentlyAdded) ? 'active' : '' ?>">Recently Added</a>
              <a href="/latest-updates" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'latestUpdates.php' || (isset($isLatestUpdates) && $isLatestUpdates) ? 'active' : '' ?>">Latest Updates</a>
              <a href="/random" class="nav-link">Random</a>
          </div>
      </div>


      <?php if (isset($role) && $role === 'admin'): ?>
      <!-- Admin Section - Only visible to admins -->
      <div class="sidebar-section">
          <div class="nav-link section-title" data-section="admin" tabindex="-1" aria-label="Admin section"><i class="bi bi-shield-lock-fill"></i> <span>Admin</span></div>
           <div class="sub-links">
              <a href="/admin/create-announcements" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'announcement.php' ? 'active' : '' ?>">Create Announcement</a>
              <a href="/admin/staff-pick" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'staff_pick.php' ? 'active' : '' ?>">Staff Picks</a>
              <a href="/admin/view-reports" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'report_controller.php' || basename($_SERVER['PHP_SELF']) == 'report_view.php' ? 'active' : '' ?>">Report</a>
           </div>
      </div>
      <?php endif; ?>
  </nav>
  <div class="sidebar-footer">
       <div class="support-placeholder my-3 text-center">
      </div>
      <div class="social-icons text-center mb-2">
          <a href="#"><i class="bi bi-discord"></i></a>
          <a href="#"><i class="bi bi-twitter-x"></i></a>
          <a href="#"><i class="bi bi-reddit"></i></a>
          <a href="#"><i class="bi bi-activity"></i></a>
      </div>
      <div class="text-center small">
        Nguyễn Hoàng Khang - 52300117
        <br>
        Hồ Gia Kiện - 52300122
      </div>
  </div>
</aside>

<!-- Script for all sidebar functionality -->
<script src="/JS/sidebar.js"></script>