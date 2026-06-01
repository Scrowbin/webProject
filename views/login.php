<?php
// Expects $errors, $forgot_password_success, $post_data from controller.
$errors = $errors ?? [];
$forgot_password_success = $forgot_password_success ?? null;
$post_data = $post_data ?? [];
$hide_auth_nav = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Optional sign-in for <?= htmlspecialchars(site_title()) ?> — a non-commercial student manga catalog project. Browse the home page without an account.">
    <title>Sign in — <?= htmlspecialchars(site_title()) ?></title>
    <link rel="icon" href="/assets/static/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/register.css">
    <link rel="stylesheet" href="/assets/css/site-identity.css">
    <script src="/assets/js/login.js"></script>
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
            <p>
                Optional account sign-in for <strong><?= htmlspecialchars(site_title()) ?></strong>.
                You do not need to log in to browse the public manga catalog on the
                <a href="<?= htmlspecialchars(app_url('/')) ?>">home page</a>.
            </p>
            <nav class="auth-page-nav" aria-label="Page navigation">
                <a href="<?= htmlspecialchars(app_url('/')) ?>"><i class="bi bi-house-door"></i> Back to home</a>
                <a href="<?= htmlspecialchars(app_url('/about')) ?>"><i class="bi bi-info-circle"></i> About this project</a>
                <a href="<?= htmlspecialchars(app_url('/register')) ?>"><i class="bi bi-person-plus"></i> Create account</a>
            </nav>
        </div>

        <div class="login-form-container p-4 rounded shadow">
            <header class="form-header text-center mb-4">
                <h1 class="h4">Sign in to your account</h1>
                <p class="text-muted small mb-0">For library, history, and comments on this site only</p>
            </header>

            <?php if ($forgot_password_success): ?>
                <div class="forgot-password-notice mb-3 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo htmlspecialchars($forgot_password_success); ?>
                </div>
            <?php endif; ?>

            <div class="form-content">
                <form novalidate class="login-form" action="<?= htmlspecialchars(app_url('/login')) ?>" method="post" autocomplete="on">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username or email</label>
                        <input tabindex="1" id="username" class="form-control form-input <?php echo !empty($errors['credentials']) ? 'input-error' : ''; ?>" name="username" type="text" autofocus autocomplete="username" value="<?php echo isset($post_data['username']) ? htmlspecialchars($post_data['username']) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input tabindex="2" id="password" class="form-control form-input <?php echo !empty($errors['credentials']) ? 'input-error' : ''; ?>" name="password" type="password" autocomplete="current-password">
                        <div class="error-message <?php echo !empty($errors['credentials']) ? 'active' : ''; ?>" id="login-error" style="margin-top: 4px;">
                            <?php if (!empty($errors['credentials'])) { echo htmlspecialchars($errors['credentials']); } ?>
                        </div>
                    </div>

                    <div class="form-options d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input tabindex="3" id="rememberMe" name="rememberMe" type="checkbox" class="form-check-input" <?php echo isset($post_data['rememberMe']) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <a href="<?= htmlspecialchars(app_url('/forgot-password')) ?>" tabindex="5" style="font-size: 14px;">Forgot password?</a>
                    </div>

                    <div class="form-buttons">
                        <button tabindex="4" class="btn submit-btn w-100" name="login" type="submit">Sign in</button>
                    </div>
                </form>

                <div class="text-center mt-3 signup-link">
                    <span>New user? <a tabindex="6" href="<?= htmlspecialchars(app_url('/register')) ?>">Register</a></span>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/includes/site_footer_disclaimer.php'; ?>
</body>
</html>
