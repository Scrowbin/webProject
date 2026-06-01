<?php
// Expects $errors, $post_data from controller.
$errors = $errors ?? [];
$post_data = $post_data ?? [];
$hide_auth_nav = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Password reset for <?= htmlspecialchars(site_title()) ?> — student project accounts only.">
    <title>Forgot password — <?= htmlspecialchars(site_title()) ?></title>
    <link rel="icon" href="/assets/static/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/register.css">
    <link rel="stylesheet" href="/assets/css/site-identity.css">
    <link rel="canonical" href="<?= htmlspecialchars(app_url('/forgot-password')) ?>" />
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars(app_url('/forgot-password')) ?>">
    <meta property="og:title" content="Forgot Password - MangaDax | Account Recovery">
    <meta property="og:description" content="Forgot your MangaDax password? Enter your username or email to receive secure password reset instructions.">
    <meta property="og:image" content="<?= htmlspecialchars(app_url('/assets/static/logo.png')) ?>">
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= htmlspecialchars(app_url('/forgot-password')) ?>">
    <meta property="twitter:title" content="Forgot Password - MangaDax | Account Recovery">
    <meta property="twitter:description" content="Forgot your MangaDax password? Enter your username or email to receive secure password reset instructions.">
    <meta property="twitter:image" content="<?= htmlspecialchars(app_url('/assets/static/logo.png')) ?>">
    <style>
        .instruction-text {
            font-size: 13px;
            color: #aaa;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #444;
            text-align: center;
        }
    </style>
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
            <nav class="auth-page-nav">
                <a href="<?= htmlspecialchars(app_url('/')) ?>"><i class="bi bi-house-door"></i> Back to home</a>
                <a href="<?= htmlspecialchars(app_url('/login')) ?>">Sign in</a>
                <a href="<?= htmlspecialchars(app_url('/about')) ?>">About</a>
            </nav>
        </div>
        <div class="login-form-container p-4 rounded shadow">
            <header class="form-header text-center mb-4">
                <h1 class="h4">Forgot your password?</h1>
            </header>

            <div class="form-content">
                <form novalidate action="<?= htmlspecialchars(app_url('/forgot-password')) ?>" method="post" autocomplete="on">
                    <div class="mb-3">
                        <label for="usernameOrEmail" class="form-label">Username or email</label>
                        <input tabindex="1" id="usernameOrEmail" class="form-control form-input <?php echo !empty($errors['credentials']) ? 'input-error' : ''; ?>" name="usernameOrEmail" type="text" required autofocus autocomplete="username" value="<?php echo isset($post_data['usernameOrEmail']) ? htmlspecialchars($post_data['usernameOrEmail']) : ''; ?>">
                        <div class="error-message <?php echo isset($errors['credentials']) ? 'active' : ''; ?>" id="forgot-error"><?php echo htmlspecialchars($errors['credentials'] ?? ''); ?></div>
                    </div>

                    <div class="mb-3">
                         <a href="<?= htmlspecialchars(app_url('/login')) ?>" class="back-to-login">&laquo; Back to Login</a>
                    </div>

                    <div class="form-buttons mb-3">
                        <button tabindex="2" class="btn submit-btn w-100" name="submit" type="submit">Submit</button>
                    </div>
                </form>
            </div>

            <p class="instruction-text">
                Enter your username or email address and we will send you instructions on how to create a new password.
            </p>

        </div>
    </div>
    <?php include __DIR__ . '/includes/site_footer_disclaimer.php'; ?>
</body>
</html>