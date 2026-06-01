<?php
// Expects $errors, $message, $message_type, $post_data, $reset_token from controller.
$errors = $errors ?? [];
$message = $message ?? '';
$message_type = $message_type ?? 'info';
$post_data = $post_data ?? [];
$reset_token = $reset_token ?? '';
$show_form = !empty($reset_token) && empty($message);
$hide_auth_nav = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Password reset for <?= htmlspecialchars(site_title()) ?> — student project accounts only.">
    <title>Reset password — <?= htmlspecialchars(site_title()) ?></title>
    <link rel="icon" href="/assets/static/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/register.css">
    <link rel="stylesheet" href="/assets/css/site-identity.css">
    <link rel="canonical" href="<?= htmlspecialchars(app_url('/reset-password')) ?>" />
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars(app_url('/reset-password')) ?>">
    <meta property="og:title" content="Reset Password - MangaDax | Secure Account Recovery">
    <meta property="og:description" content="Reset your MangaDax password securely. Create a new password to regain access to your manga collection.">
    <meta property="og:image" content="<?= htmlspecialchars(app_url('/assets/static/logo.png')) ?>">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= htmlspecialchars(app_url('/reset-password')) ?>">
    <meta property="twitter:title" content="Reset Password - MangaDax | Secure Account Recovery">
    <meta property="twitter:description" content="Reset your MangaDax password securely. Create a new password to regain access to your manga collection.">
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
            <nav class="auth-page-nav">
                <a href="<?= htmlspecialchars(app_url('/')) ?>"><i class="bi bi-house-door"></i> Back to home</a>
                <a href="<?= htmlspecialchars(app_url('/login')) ?>">Sign in</a>
                <a href="<?= htmlspecialchars(app_url('/about')) ?>">About</a>
            </nav>
        </div>
        <div class="login-form-container p-4 rounded shadow">
            <header class="form-header text-center mb-4">
                <h1 class="h4">Reset password</h1>
            </header>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
                <div class="text-center mt-3">
                    <a href="<?= htmlspecialchars(app_url('/login')) ?>" class="btn btn-primary">Go to Login</a>
                </div>
            <?php elseif ($show_form): ?>
                <div class="form-content">
                    <form novalidate onsubmit="return validateForm()" action="<?= htmlspecialchars(app_url('/reset-password/' . $reset_token)) ?>" method="post" autocomplete="on">
                        <?php if (!empty($errors['db'])): ?>
                            <div class="mb-3 error-message active" style="text-align: center;"><?php echo htmlspecialchars($errors['db']); ?></div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password <span class="required">*</span></label>
                            <input tabindex="1" id="password" class="form-control form-input <?php echo isset($errors['password']) ? 'input-error' : ''; ?>" name="password" type="password" required autocomplete="new-password">
                            <div class="error-message <?php echo isset($errors['password']) ? 'active' : ''; ?>" id="pwd-error"><?php echo htmlspecialchars($errors['password'] ?? ''); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="cf_password" class="form-label">Confirm New Password <span class="required">*</span></label>
                            <input tabindex="2" id="cf_password" class="form-control form-input <?php echo isset($errors['cf_password']) ? 'input-error' : ''; ?>" name="cf_password" type="password" required autocomplete="new-password">
                            <div class="error-message <?php echo isset($errors['cf_password']) ? 'active' : ''; ?>" id="cfpwd-error"><?php echo htmlspecialchars($errors['cf_password'] ?? ''); ?></div>
                        </div>
                        <div class="form-buttons">
                            <button tabindex="3" class="btn submit-btn w-100" name="reset" type="submit">Reset Password</button>
                        </div>
                    </form>
                </div>

                <script>
                function validateForm() {
                    const password = document.getElementById('password');
                    const cfPassword = document.getElementById('cf_password');
                    const pwdError = document.getElementById('pwd-error');
                    const cfPwdError = document.getElementById('cfpwd-error');

                    // Reset error states
                    password.classList.remove('input-error');
                    cfPassword.classList.remove('input-error');
                    pwdError.classList.remove('active');
                    cfPwdError.classList.remove('active');

                    let isValid = true;

                    // Check if password is empty
                    if (password.value.trim() === '') {
                        password.classList.add('input-error');
                        pwdError.textContent = 'Please specify password.';
                        pwdError.classList.add('active');
                        isValid = false;
                    }
                    // Check password requirements
                    else if (password.value.length < 8 || password.value.length > 24) {
                        password.classList.add('input-error');
                        pwdError.textContent = 'Password must be between 8 and 24 characters.';
                        pwdError.classList.add('active');
                        isValid = false;
                    }
                    else if (!/[A-Za-z]/.test(password.value) || !/[0-9]/.test(password.value) || !/[@$!%*?&]/.test(password.value)) {
                        password.classList.add('input-error');
                        pwdError.textContent = 'Password must contain at least one letter, one number, and one special character (@$!%*?&).';
                        pwdError.classList.add('active');
                        isValid = false;
                    }

                    // Check if confirm password is empty
                    if (cfPassword.value.trim() === '') {
                        cfPassword.classList.add('input-error');
                        cfPwdError.textContent = 'Please confirm your password.';
                        cfPwdError.classList.add('active');
                        isValid = false;
                    }
                    // Check if passwords match
                    else if (password.value !== cfPassword.value) {
                        cfPassword.classList.add('input-error');
                        cfPwdError.textContent = 'Passwords do not match.';
                        cfPwdError.classList.add('active');
                        isValid = false;
                    }

                    return isValid;
                }
                </script>
            <?php else: ?>
                <div class="alert alert-danger">
                    Invalid or missing reset token. Please request a new password reset link.
                </div>
                <div class="text-center mt-3">
                    <a href="<?= htmlspecialchars(app_url('/forgot-password')) ?>" class="btn btn-primary">Request New Reset Link</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include __DIR__ . '/includes/site_footer_disclaimer.php'; ?>
</body>
</html>
