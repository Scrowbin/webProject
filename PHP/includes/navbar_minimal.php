<?php
// Ensure session is started (might be started by db_config.php or other includes)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION['userID']);
$username = $is_logged_in && isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';

// Default avatar path
$user_avatar = 'IMG/avatar_default.png'; // Path relative to index.php

// If user is logged in, fetch their avatar from the database
if ($is_logged_in && isset($_SESSION['userID'])) {
    // Make sure we have access to the account_find_by_userID function
    if (!function_exists('account_find_by_userID')) {
        require_once __DIR__ . '/../../db/account_db.php';
    }

    // Get user data including avatar
    $user_data = account_find_by_userID($_SESSION['userID']);

    // If user has a custom avatar, use it
    if ($user_data && !empty($user_data['Avatar']) && $user_data['Avatar'] !== 'avatar_default.png') {
        $user_avatar = 'IMG/avatars/' . htmlspecialchars($user_data['Avatar']);
    }
}
?>

<!-- Minimal Navigation Bar (Static) - Only Logo and Avatar -->
<nav class="navbar navbar-minimal">
  <div class="container">
    <?php // Link to index.php (homepage controller) ?>
    <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="index.php">
       <?php // Corrected path for logo ?>
       <img src="IMG/logo.png" alt="Logo" style="height: 30px; margin-right: 8px;">
       MangaDax
    </a>

    <div class="ms-auto"></div> <!-- Spacer -->

    <button class="btn text-white p-0" type="button" id="user-avatar-btn" data-bs-toggle="modal" data-bs-target="#user-modal">
      <?php if ($is_logged_in): ?>
        <?php // Using the user's avatar from database ?>
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
            <a class="nav-link text-white" href="profile"><i class="bi bi-person me-2"></i> My Profile</a>
            <a class="nav-link text-white" href="controller/follows_controller.php"><i class="bi bi-bookmark me-2"></i> My Follows</a>
          </nav>

          <hr class="user-modal-divider mt-2 mb-2">

          <div class="d-flex justify-content-between mb-2 user-modal-actions px-2">
            <?php // Link to profile controller action ?>
            <a href="controller/auth_controller.php?action=profile" class="text-decoration-none text-white d-flex align-items-center"><i class="bi bi-gear me-2"></i> Settings</a>
          </div>

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
          </div>
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
