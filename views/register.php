<?php
// Expects $errors, $success_data, $post_data from controller.
$errors = $errors ?? [];
$success_data = $success_data ?? null;
$post_data = $post_data ?? [];
$is_success = !empty($success_data);
$hide_auth_nav = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Create an optional account on <?= htmlspecialchars(site_title()) ?> — a non-commercial student manga catalog project.">
    <title>Register — <?= htmlspecialchars(site_title()) ?></title>
    <link rel="icon" href="/assets/static/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/register.css">
    <link rel="stylesheet" href="/assets/css/site-identity.css">
    <link rel="canonical" href="<?= htmlspecialchars(app_url('/register')) ?>" />
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars(app_url('/register')) ?>">
    <meta property="og:title" content="Register — <?= htmlspecialchars(site_title()) ?>">
    <meta property="og:description" content="Optional account registration for <?= htmlspecialchars(site_title()) ?>.">
    <meta property="og:image" content="<?= htmlspecialchars(app_url('/assets/static/logo.png')) ?>">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= htmlspecialchars(app_url('/register')) ?>">
    <meta property="twitter:title" content="Register — <?= htmlspecialchars(site_title()) ?>">
    <meta property="twitter:description" content="Optional account registration for <?= htmlspecialchars(site_title()) ?>.">
    <meta property="twitter:image" content="<?= htmlspecialchars(app_url('/assets/static/logo.png')) ?>">
</head>
<body>
    <?php include __DIR__ . '/includes/site_identity_bar.php'; ?>
    <div class="container login-page">
        <div class="page-header text-center py-4">
            <a href="<?= htmlspecialchars(app_url('/')) ?>">
                <div class="logo-container d-flex align-items-center justify-content-center">
                     <img src="/assets/static/logo.png" alt="<?= htmlspecialchars(site_name()) ?> logo" style="height: 40px; margin-right: 10px;">
                    <span id="md-wordmark"><?= htmlspecialchars(site_name()) ?></span>
                </div>
            </a>
        </div>
        <div class="auth-page-context">
            <p>Optional registration for this student project. <a href="<?= htmlspecialchars(app_url('/')) ?>">Browse the catalog</a> without an account.</p>
            <nav class="auth-page-nav">
                <a href="<?= htmlspecialchars(app_url('/')) ?>"><i class="bi bi-house-door"></i> Back to home</a>
                <a href="<?= htmlspecialchars(app_url('/about')) ?>">About</a>
                <a href="<?= htmlspecialchars(app_url('/login')) ?>">Sign in</a>
            </nav>
        </div>
        <div class="login-form-container p-4 rounded shadow">
            <header class="form-header text-center mb-4">
                <h1 class="h4">Create an account</h1>
                <p class="text-muted small mb-0">For this site only — not a third-party service</p>
            </header>

            <?php if ($is_success): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success_data['message']); ?>
                </div>
                 <div class="text-center mt-3">
                     <a href="<?= htmlspecialchars(app_url('/login')) ?>" class="btn btn-primary">Proceed to Login</a>
                 </div>
            <?php else: ?>
            <div class="form-content">
                <form novalidate onsubmit="return validInput()" action="<?= htmlspecialchars(app_url('/register')) ?>" method="post" autocomplete="on">
                    <?php if (!empty($errors['db'])): ?>
                        <div class="mb-3 error-message active" style="text-align: center;"><?php echo htmlspecialchars($errors['db']); ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span class="required">*</span></label>
                        <input tabindex="1" id="username" class="form-control form-input <?php echo isset($errors['username']) ? 'input-error' : ''; ?>" name="username" type="text" required autocomplete="username" value="<?php echo isset($post_data['username']) ? htmlspecialchars($post_data['username']) : ''; ?>">
                        <div class="error-message <?php echo isset($errors['username']) ? 'active' : ''; ?>" id="username-error"><?php echo htmlspecialchars($errors['username'] ?? ''); ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="required">*</span></label>
                        <input tabindex="2" id="password" class="form-control form-input <?php echo isset($errors['password']) ? 'input-error' : ''; ?>" name="password" type="password" required autocomplete="new-password">
                        <div class="error-message <?php echo isset($errors['password']) ? 'active' : ''; ?>" id="pwd-error"><?php echo htmlspecialchars($errors['password'] ?? ''); ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="cf_password" class="form-label">Confirm Password <span class="required">*</span></label>
                        <input tabindex="3" id="cf_password" class="form-control form-input <?php echo isset($errors['cf_password']) ? 'input-error' : ''; ?>" name="cf_password" type="password" required autocomplete="new-password">
                        <div class="error-message <?php echo isset($errors['cf_password']) ? 'active' : ''; ?>" id="cfpwd-error"><?php echo htmlspecialchars($errors['cf_password'] ?? ''); ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="required">*</span></label>
                        <input tabindex="4" id="email" class="form-control form-input <?php echo isset($errors['email']) ? 'input-error' : ''; ?>" name="email" type="email" required autocomplete="email" value="<?php echo isset($post_data['email']) ? htmlspecialchars($post_data['email']) : '';?>">
                        <div class="error-message <?php echo isset($errors['email']) ? 'active' : ''; ?>" id="email-error"><?php echo htmlspecialchars($errors['email'] ?? ''); ?></div>
                    </div>
                    <div class="mb-3">
                        <a href="<?= htmlspecialchars(app_url('/login')) ?>" class="back-to-login">&laquo; Back to Login</a>
                    </div>
                    <div class="form-buttons">
                        <button tabindex="5" class="btn submit-btn w-100" name="register" type="submit">Register</button>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Client-side validation -->
    <script src="/assets/js/register.js"></script>
    <?php include __DIR__ . '/includes/site_footer_disclaimer.php'; ?>
</body>
</html>

