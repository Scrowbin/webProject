<?php
// Expects $errors, $forgot_password_success, $post_data from controller.
$errors = $errors ?? [];
$forgot_password_success = $forgot_password_success ?? null;
$post_data = $post_data ?? [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sign in to your MangaDax account to access your manga library, reading history, and personalized recommendations.">
    <meta name="keywords" content="manga, login, sign in, MangaDax, account">
    <title>Sign in to MangaDax</title>
    <link rel="icon" href="../IMG/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/register.css">
    <script src="../JS/login.js"></script>
</head>
<body>
    <div class="container login-page">
        <div class="page-header text-center py-4">
            <a href="../index.php" rel="nofollow">
                <div class="logo-container d-flex align-items-center justify-content-center">
                    <img src="../IMG/logo.png" alt="MangaDax Logo" style="height: 40px; margin-right: 10px;">
                    <span id="md-wordmark">MangaDax</span>
                </div>
            </a>
        </div>
        <div class="login-form-container p-4 rounded shadow">
            <header class="form-header text-center mb-4">
                <h1>Sign in to your account</h1>
            </header>

            <?php if ($forgot_password_success): ?>
                <div class="forgot-password-notice mb-3 d-flex align-items-center">
                     <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo htmlspecialchars($forgot_password_success); ?>
                </div>
            <?php endif; ?>

            <div class="form-content">
                <form novalidate class="login-form" action="../login" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username or email</label>
                        <input tabindex="1" id="username" class="form-control form-input <?php echo !empty($errors['credentials']) ? 'input-error' : ''; ?>" name="username" type="text" autofocus autocomplete="off" value="<?php echo isset($post_data['username']) ? htmlspecialchars($post_data['username']) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input tabindex="2" id="password" class="form-control form-input <?php echo !empty($errors['credentials']) ? 'input-error' : ''; ?>" name="password" type="password" autocomplete="off">
                        <div class="error-message <?php echo !empty($errors['credentials']) ? 'active' : ''; ?>" id="login-error" style="margin-top: 4px;">
                            <?php if (!empty($errors['credentials'])) { echo htmlspecialchars($errors['credentials']); } ?>
                        </div>
                    </div>

                    <div class="form-options d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input tabindex="3" id="rememberMe" name="rememberMe" type="checkbox" class="form-check-input" <?php echo isset($post_data['rememberMe']) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <a href="../forgot-password" tabindex="5" style="font-size: 14px;">Forgot Password?</a>
                    </div>

                    <div class="form-buttons">
                        <button tabindex="4" class="btn submit-btn w-100" name="login" type="submit">Sign in</button>
                    </div>
                </form>



                <div class="text-center mt-3 signup-link">
                    <span>New user? <a tabindex="6" href="../register">Register</a></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>