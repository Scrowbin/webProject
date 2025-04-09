<?php
// Ensure session is started (might be started by db_config.php or other includes)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION['username']);
$username = $is_logged_in ? htmlspecialchars($_SESSION['username']) : 'Guest';
// Corrected path for default avatar
$user_avatar = 'IMG/avatar_default.png'; // Path relative to index.php
?>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <button class="btn text-white ps-0 me-2" type="button" id="hamburger-btn">
      <i class="bi bi-list fs-3"></i>
    </button>
    <?php // Link to index.php (homepage controller) ?>
    <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="index.php">
       <?php // Corrected path for logo ?>
       <img src="IMG/logo.png" alt="Logo" style="height: 30px; margin-right: 8px;"> 
       MangaDax
    </a>
    
    <div class="search-box d-flex align-items-center ms-auto me-3">
      <input type="text" class="form-control border-0" placeholder="Search"/>
      <span class="shortcut-key text-white-50 ms-2 d-none d-md-inline">Ctrl</span>
      <span class="shortcut-key text-white-50 ms-2 d-none d-md-inline">K</span>
      <i class="bi bi-search text-white ms-2"></i>
    </div>
    <button class="btn text-white p-0" type="button" id="user-avatar-btn" data-bs-toggle="modal" data-bs-target="#user-modal">
      <?php if ($is_logged_in): ?>
        <?php // Path to avatar is correct now ?>
        <img src="<?php echo $user_avatar; ?>" alt="User Avatar" class="rounded-circle" width="32" height="32">
      <?php else: ?>
        <i class="bi bi-person-circle fs-3"></i> <?php /* Display default icon */ ?>
      <?php endif; ?>
    </button>
  </div>
</nav> 

<!-- User Modal -->
<div class="modal fade" id="user-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm user-modal-dialog">
    <div class="modal-content user-modal-content">
      <div class="modal-body user-modal-body p-3">

        <?php if ($is_logged_in): ?>
          <!---------- LOGGED IN VIEW ---------->
          <div class="text-center mb-3">
            <img src="<?php echo $user_avatar; ?>" alt="User Avatar" class="rounded-circle mb-2" width="64" height="64">
            <h5 class="mt-1 mb-1 text-white"><?php echo $username; ?></h5>
            <span class="badge bg-secondary">User</span>
            <hr class="user-modal-divider mt-3 mb-2">
          </div>

          <nav class="nav flex-column user-modal-nav mb-2">
            <?php // Link to profile controller action ?>
            <a class="nav-link text-white" href="controller/auth_controller.php?action=profile"><i class="bi bi-person me-2"></i> My Profile</a>
            <a class="nav-link text-white" href="#"><i class="bi bi-bookmark me-2"></i> My Follows</a>
            <a class="nav-link text-white" href="#"><i class="bi bi-list-ul me-2"></i> My Lists</a>
            <a class="nav-link text-white" href="#"><i class="bi bi-people me-2"></i> My Groups</a>
            <a class="nav-link text-white" href="#"><i class="bi bi-megaphone me-2"></i> My Reports</a>
            <a class="nav-link text-white" href="#"><i class="bi bi-info-circle me-2"></i> Announcements</a>
          </nav>

          <hr class="user-modal-divider mt-2 mb-2">

          <div class="d-flex justify-content-between mb-2 user-modal-actions px-2">
            <?php // Link to profile controller action ?>
            <a href="controller/auth_controller.php?action=profile" class="text-decoration-none text-white d-flex align-items-center"><i class="bi bi-gear me-2"></i> Settings</a>
            <a href="#" class="text-decoration-none text-white d-flex align-items-center"><i class="bi bi-droplet me-2"></i> Theme</a>
          </div>

          <nav class="nav flex-column user-modal-nav mb-2">
            <a class="nav-link text-white" href="#">Content Filter</a>
          </nav>

          <hr class="user-modal-divider mt-2 mb-3">

          <div class="d-grid gap-2 px-2">
             <?php // Link to logout controller action ?>
             <a href="controller/auth_controller.php?action=logout" class="btn btn-sm btn-outline-light d-flex align-items-center justify-content-center" type="button"><i class="bi bi-box-arrow-right me-2"></i> Sign Out</a>
          </div>
          <!---------- END LOGGED IN VIEW ---------->

        <?php else: ?>
          <!---------- GUEST VIEW ---------->
          <div class="text-center mb-3">
            <i class="bi bi-person-circle display-4 text-white"></i>
            <h5 class="mt-2 mb-3 text-white">Guest</h5>
            <hr class="user-modal-divider">
          </div>
          <div class="d-flex justify-content-between mb-3 user-modal-actions">
            <a href="#" class="text-decoration-none text-white d-flex align-items-center"><i class="bi bi-gear-fill me-2"></i> Settings</a>
            <a href="#" class="text-decoration-none text-white d-flex align-items-center"><i class="bi bi-droplet-half me-2"></i> Theme</a>
          </div>
          <div class="mb-3"><a href="#" class="text-decoration-none text-white">Content Filter</a></div>
          <hr class="user-modal-divider mb-3">
          <div class="d-grid gap-2">
            <?php // Link to login controller action ?>
            <a href="controller/auth_controller.php?action=login" class="btn btn-primary btn-user-action sign-in-btn" type="button">Sign In</a>
            <?php // Link to register controller action ?>
            <a href="controller/auth_controller.php?action=register" class="text-center text-white-50 text-decoration-none small">Register</a>
          </div>
          <!---------- END GUEST VIEW ---------->
        <?php endif; ?>

      </div>
    </div>
  </div>
</div> 