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
      <a href="<?= $pathPrefix ?>index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>"><i class="bi bi-house-door-fill"></i> Home</a>
      <a href="<?= $pathPrefix ?>controller/follows_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'follows.php' || (isset($isFollows) && $isFollows) ? 'active' : '' ?>"><i class="bi bi-arrow-repeat"></i> Updates</a>
      <a href="<?= $pathPrefix ?>controller/library_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'library.php' || (isset($isLibrary) && $isLibrary) ? 'active' : '' ?>"><i class="bi bi-collection-fill"></i> Library</a>
      <a href="#" class="nav-link"><i class="bi bi-list-ul"></i> MDLists</a>
      <a href="#" class="nav-link"><i class="bi bi-clock-history"></i> Reading History</a>

      <div class="sidebar-section">
          <a href="<?= $pathPrefix ?>controller/create_controller.php" class="nav-link section-title"><i class="bi bi-book-fill"></i> Titles <i class="bi bi-plus-lg float-end"></i></a>
          <div class="sub-links">
              <a href="#" class="nav-link">Advanced Search</a>
              <a href="<?= $pathPrefix ?>controller/recently_added_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'recently_added_controller.php' || (isset($isRecentlyAdded) && $isRecentlyAdded) ? 'active' : '' ?>">Recently Added</a>
              <a href="<?= $pathPrefix ?>controller/latestUpdates_controller.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'latestUpdates.php' || (isset($isLatestUpdates) && $isLatestUpdates) ? 'active' : '' ?>">Latest Updates</a>
              <a href="#" class="nav-link">Random</a>
          </div>
      </div>

      <div class="sidebar-section">
          <a href="#" class="nav-link section-title"><i class="bi bi-chat-dots-fill"></i> Community <i class="bi bi-plus-lg float-end"></i></a>
           <div class="sub-links">
              <a href="#" class="nav-link">Forums</a>
              <a href="#" class="nav-link">Groups</a>
              <a href="#" class="nav-link">Users</a>
          </div>
      </div>

       <div class="sidebar-section">
          <a href="#" class="nav-link section-title"><i class="bi bi-speedometer2"></i> MangaDex</a>
           <div class="sub-links">
              <a href="#" class="nav-link">Site Rules</a>
              <a href="#" class="nav-link">Announcements</a>
              <a href="#" class="nav-link">About Us</a>
              <a href="#" class="nav-link">Contact</a>
           </div>
      </div>
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