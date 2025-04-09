<?php
// Expects $errors, $success_data, $post_data from controller.
$errors = $errors ?? [];
$success_data = $success_data ?? null;
$post_data = $post_data ?? [];
$is_success = !empty($success_data);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register MangaDax</title>
    <link rel="icon" href="../IMG/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/register.css">
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
                <h1>Create an Account</h1>
            </header>

            <?php if ($is_success): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success_data['message']); ?><br>
                    <?php echo $success_data['activation_link_html']; ?>
                </div>
                 <div class="text-center mt-3">
                     <a href="../controller/auth_controller.php?action=login" class="btn btn-primary">Proceed to Login</a>
                 </div>
            <?php else: ?>
            <div class="form-content">
                <form novalidate action="../controller/auth_controller.php?action=register" method="post">
                    <?php if (!empty($errors['db'])): ?>
                        <div class="mb-3 error-message active" style="text-align: center;"><?php echo htmlspecialchars($errors['db']); ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span class="required">*</span></label>
                        <input tabindex="1" id="username" class="form-control form-input <?php echo isset($errors['username']) ? 'input-error' : ''; ?>" name="username" type="text" required autocomplete="off" value="<?php echo isset($post_data['username']) ? htmlspecialchars($post_data['username']) : ''; ?>">
                        <div class="error-message <?php echo isset($errors['username']) ? 'active' : ''; ?>" id="username-error"><?php echo htmlspecialchars($errors['username'] ?? ''); ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="required">*</span></label>
                        <input tabindex="2" id="password" class="form-control form-input <?php echo isset($errors['password']) ? 'input-error' : ''; ?>" name="password" type="password" required autocomplete="off">
                        <div class="error-message <?php echo isset($errors['password']) ? 'active' : ''; ?>" id="pwd-error"><?php echo htmlspecialchars($errors['password'] ?? ''); ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="cf_password" class="form-label">Confirm Password <span class="required">*</span></label>
                        <input tabindex="3" id="cf_password" class="form-control form-input <?php echo isset($errors['cf_password']) ? 'input-error' : ''; ?>" name="cf_password" type="password" required autocomplete="off">
                        <div class="error-message <?php echo isset($errors['cf_password']) ? 'active' : ''; ?>" id="cfpwd-error"><?php echo htmlspecialchars($errors['cf_password'] ?? ''); ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="required">*</span></label>
                        <input tabindex="4" id="email" class="form-control form-input <?php echo isset($errors['email']) ? 'input-error' : ''; ?>" name="email" type="email" required autocomplete="off" value="<?php echo isset($post_data['email']) ? htmlspecialchars($post_data['email']) : '';?>">
                        <div class="error-message <?php echo isset($errors['email']) ? 'active' : ''; ?>" id="email-error"><?php echo htmlspecialchars($errors['email'] ?? ''); ?></div>
                    </div>
                    <div class="mb-3">
                        <a href="../controller/auth_controller.php?action=login" class="back-to-login">&laquo; Back to Login</a>
                    </div>
                    <div class="form-buttons">
                        <button tabindex="5" class="btn submit-btn w-100" name="register" type="submit">Register</button>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Server side validation is primary -->
</body>
</html>

