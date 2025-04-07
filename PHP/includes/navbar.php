<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <button class="btn text-white ps-0 me-2" type="button" id="hamburger-btn">
      <i class="bi bi-list fs-3"></i>
    </button>
    <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="homepage.html">
       MangaDax
    </a>
    
    <div class="search-box d-flex align-items-center ms-auto me-3">
      <input type="text" class="form-control border-0" placeholder="Search"/>
      <span class="shortcut-key text-white-50 ms-2 d-none d-md-inline">Ctrl</span>
      <span class="shortcut-key text-white-50 ms-2 d-none d-md-inline">K</span>
      <i class="bi bi-search text-white ms-2"></i>
    </div>
    <button class="btn text-white p-0" type="button" id="user-avatar-btn">
      <i class="bi bi-person-circle fs-3"></i>
    </button>
  </div>
</nav> 

<!-- User Modal -->
<div class="modal fade" id="user-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm user-modal-dialog">
    <div class="modal-content user-modal-content">
      <div class="modal-body user-modal-body">
        <div class="text-center mb-3">
          <i class="bi bi-person-circle display-4 text-white"></i>
          <h5 class="mt-2 mb-3 text-white">Guest</h5>
          <hr class="user-modal-divider">
        </div>
        <div class="d-flex justify-content-between mb-3 user-modal-actions">
          <a href="#" class="text-decoration-none text-white d-flex align-items-center"><i class="bi bi-gear-fill me-2"></i> Settings</a>
          <a href="#" class="text-decoration-none text-white d-flex align-items-center"><i class="bi bi-droplet-half me-2"></i> Theme</a>
        </div>
        <div class="mb-2"><a href="#" class="text-decoration-none text-white d-flex justify-content-between align-items-center">Interface Language <span class="badge bg-warning text-dark beta-badge">BETA</span></a></div>
        <div class="mb-2"><a href="#" class="text-decoration-none text-white d-flex justify-content-between align-items-center">Chapter Languages <span class="badge bg-secondary all-badge">All</span></a></div>
        <div class="mb-3"><a href="#" class="text-decoration-none text-white">Content Filter</a></div>
        <hr class="user-modal-divider mb-3">
        <div class="d-grid gap-2">
          <a href="login.php" class="btn btn-primary btn-user-action sign-in-btn" type="button">Sign In</a>
          <a href="register.php" class="text-center text-white-50 text-decoration-none small">Register</a>
        </div>
      </div>
    </div>
  </div>
</div> 