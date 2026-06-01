<?php
/**
 * Visible site identity for auth pages and trust signals (not a bare login form).
 */
?>
<div class="site-identity-bar">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <div class="site-title"><?= htmlspecialchars(site_title()) ?></div>
            <div class="site-meta">
                Student project · <?= htmlspecialchars(site_author()) ?>
                · <?= htmlspecialchars(site_subtitle()) ?>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-3">
            <a href="<?= htmlspecialchars(app_url('/')) ?>"><i class="bi bi-house-door"></i> Home catalog</a>
            <a href="<?= htmlspecialchars(app_url('/about')) ?>"><i class="bi bi-info-circle"></i> About</a>
            <?php if (empty($hide_auth_nav)): ?>
            <a href="<?= htmlspecialchars(app_url('/login')) ?>">Sign in</a>
            <a href="<?= htmlspecialchars(app_url('/register')) ?>">Register</a>
            <?php endif; ?>
        </div>
    </div>
</div>
