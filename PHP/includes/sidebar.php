<aside id="nav-sidebar">
  <div class="sidebar-header">
  <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="<?= $pathPrefix ?>index.php">
       <?php // Corrected path for logo ?>
       <img src="<?= $pathPrefix ?>IMG/logo.png" alt="Logo" style="height: 30px; margin-right: 8px;">
       MangaDax
    </a>
    <button class="btn text-white close-btn" type="button">
      <i class="bi bi-x-lg fs-4"></i>
    </button>
  </div>
  <nav class="sidebar-nav">
      <!-- Home as a standalone section -->
      <a href="<?= $pathPrefix ?>index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>"><i class="bi bi-house-door-fill"></i> <span>Home</span></a>

      <!-- Follows section with subsections -->
      <div class="sidebar-section">
          <div class="nav-link section-title <?= basename($_SERVER['PHP_SELF']) == 'follows.php' || (isset($isFollows) && $isFollows) ? 'active' : '' ?>" data-section="follows"><i class="bi bi-bookmark-fill"></i> <span>Follows</span></div>
          <div class="sub-links">
              <a href="<?= $pathPrefix ?>controller/follows_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'follows.php' || (isset($isFollows) && $isFollows) ? 'active' : '' ?>">Updates</a>
              <a href="<?= $pathPrefix ?>controller/library_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'library.php' || (isset($isLibrary) && $isLibrary) ? 'active' : '' ?>">Library</a>
              <a href="<?= $pathPrefix ?>controller/readingHistory_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'readingHistory_controller.php' || (isset($isReadingHistory) && $isReadingHistory) ? 'active' : '' ?>">Reading History</a>
          </div>
      </div>

      <!-- Titles section (unchanged) -->
      <div class="sidebar-section">
          <a href="<?= $pathPrefix ?>controller/create_controller.php" class="nav-link section-title" data-section="titles"><i class="bi bi-book-fill"></i> <span>Titles</span> <i class="bi bi-plus-lg float-end"></i></a>
          <div class="sub-links">
              <a href="<?= $pathPrefix ?>controller/advanced_search_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'advanced_search.php' || (isset($isAdvancedSearch) && $isAdvancedSearch) ? 'active' : '' ?>">Advanced Search</a>
              <a href="<?= $pathPrefix ?>controller/recently_added_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'recently_added_controller.php' || (isset($isRecentlyAdded) && $isRecentlyAdded) ? 'active' : '' ?>">Recently Added</a>
              <a href="<?= $pathPrefix ?>controller/latestUpdates_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'latestUpdates.php' || (isset($isLatestUpdates) && $isLatestUpdates) ? 'active' : '' ?>">Latest Updates</a>
              <a href="<?= $pathPrefix ?>controller/random_manga_controller.php" class="nav-link">Random</a>
          </div>
      </div>


      <!-- MangaDex Section - Visible to all users -->
      <div class="sidebar-section">
          <div class="nav-link section-title" data-section="mangadex"><i class="bi bi-speedometer2"></i> <span>MangaDex</span></div>
           <div class="sub-links">
              <a href="<?= $pathPrefix ?>controller/announcement_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'announcement.php' ? 'active' : '' ?>">Announcements</a>
              <!-- Report link - Visible to all but only admins can access -->
              <a href="<?= $pathPrefix ?>controller/report_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'report_controller.php' || basename($_SERVER['PHP_SELF']) == 'report_view.php' ? 'active' : '' ?>">Report</a>
           </div>
      </div>

      <?php if (isset($role) && $role === 'admin'): ?>
      <!-- Admin Section - Only visible to admins -->
      <div class="sidebar-section">
          <div class="nav-link section-title" data-section="admin"><i class="bi bi-shield-lock-fill"></i> <span>Admin</span></div>
           <div class="sub-links">
              <a href="<?= $pathPrefix ?>controller/announcement_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'announcement.php' ? 'active' : '' ?>">Create Announcement</a>
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
      <div class="text-center text-muted small">
          © MangaDex 2025
      </div>
  </div>
</aside>