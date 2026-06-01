<?php
if (!function_exists('site_title')) {
    require_once __DIR__ . '/../../config/bootstrap.php';
}

$currentPath = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '', '/');
$navActive = static function (string $page) use ($currentPath): string {
    $target = parse_url(page_url($page), PHP_URL_PATH) ?? '';
    $target = trim($target, '/');
    if ($target === '') {
        return '';
    }
    if ($currentPath === $target) {
        return ' active';
    }
    if (str_contains($currentPath, trim($target, '/'))) {
        return ' active';
    }
    $pretty = trim($page, '/');
    if ($currentPath === $pretty || str_starts_with($currentPath, $pretty . '/')) {
        return ' active';
    }
    return '';
};
?>
<!-- Sidebar -->
<aside id="nav-sidebar">
  <div class="sidebar-header">
    <a class="navbar-brand text-white fw-bold d-flex align-items-center sidebar-logo" href="/">
       <?= htmlspecialchars(site_name()) ?>
    </a>
    <button class="btn text-white close-btn" type="button">
      <i class="bi bi-x-lg fs-4"></i>
    </button>
  </div>
  <nav class="sidebar-nav">
      <a href="/" class="nav-link<?= ($currentPath === '' || $currentPath === 'index.php') ? ' active' : '' ?>"><i class="bi bi-house-door-fill"></i> Home</a>
      <a href="<?= htmlspecialchars(page_url('my-follows')) ?>" class="nav-link<?= $navActive('my-follows') ?>"><i class="bi bi-bookmark-fill"></i> Follows</a>
      <a href="<?= htmlspecialchars(page_url('latest-updates')) ?>" class="nav-link<?= $navActive('latest-updates') ?>"><i class="bi bi-arrow-repeat"></i> Updates</a>
      <a href="<?= htmlspecialchars(page_url('library')) ?>" class="nav-link<?= $navActive('library') ?>"><i class="bi bi-collection-fill"></i> Library</a>
      <a href="<?= htmlspecialchars(page_url('reading-history')) ?>" class="nav-link<?= $navActive('reading-history') ?>"><i class="bi bi-clock-history"></i> Reading History</a>

      <div class="sidebar-section">
          <a href="#" class="nav-link section-title"><i class="bi bi-book-fill"></i> Titles <i class="bi bi-plus-lg float-end"></i></a>
          <div class="sub-links">
              <a href="<?= htmlspecialchars(page_url('advanced-search')) ?>" class="nav-link<?= $navActive('advanced-search') ?>">Advanced Search</a>
              <a href="<?= htmlspecialchars(page_url('recently-added')) ?>" class="nav-link<?= $navActive('recently-added') ?>">Recently Added</a>
              <a href="<?= htmlspecialchars(page_url('latest-updates')) ?>" class="nav-link<?= $navActive('latest-updates') ?>">Latest Updates</a>
              <a href="<?= htmlspecialchars(page_url('random')) ?>" class="nav-link<?= $navActive('random') ?>">Random</a>
          </div>
      </div>

       <div class="sidebar-section">
          <a href="#" class="nav-link section-title"><i class="bi bi-info-circle"></i> Project</a>
           <div class="sub-links">
              <a href="<?= htmlspecialchars(page_url('about')) ?>" class="nav-link<?= $navActive('about') ?>">About this site</a>
              <a href="<?= htmlspecialchars(page_url('login')) ?>" class="nav-link<?= $navActive('login') ?>">Sign in</a>
              <a href="<?= htmlspecialchars(page_url('register')) ?>" class="nav-link<?= $navActive('register') ?>">Register</a>
           </div>
      </div>
  </nav>
  <div class="sidebar-footer">
       <div class="support-placeholder my-3 text-center">
      </div>
      <div class="text-center text-muted small">
          © <?= date('Y') ?> <?= htmlspecialchars(site_name()) ?> · Student project
      </div>
  </div>
</aside>
