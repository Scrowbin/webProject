<?php
// Include the controller and call the handler function
require_once __DIR__ . '/../controller/auth_controller.php';

// The handleLogin function will either redirect (on success/already logged in)
// or return data needed for the view.
$viewData = handleLogin();

// Extract variables for easier access in the view
$errors = $viewData['errors'];
$forgot_password_success = $viewData['forgot_password_success'];

// --- The rest of the file is the View ---
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in to MangaDax</title>
    <link rel="icon" href="../IMG/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/register.css">
    <script src="../JS/login.js"></script>
</head>
<body>
    <div class="container login-page">
        <div class="page-header text-center py-4">
            <a href="homepage.php" rel="nofollow">
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

            <?php // Display success message from forgot password if it exists ?>
            <?php if ($forgot_password_success): ?>
                <div class="forgot-password-notice mb-3 d-flex align-items-center">
                     <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo htmlspecialchars($forgot_password_success); ?>
                </div>
            <?php endif; ?>

            <?php /* Display login errors using custom style */ ?>
            <?php if (!empty($errors)): ?>
                <?php /* Note: error message div is now inside the form below password field */ ?>
            <?php endif; ?>

            <div class="form-content">
                 <?php // Point form action to the current file (which includes the controller) ?>
                <form novalidate class="login-form" action="login.php" method="post">
                    <!-- username-->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username or email</label>
                        <?php // Add error class and retain value ?>
                        <input tabindex="1" id="username" class="form-control form-input <?php echo !empty($errors) ? 'input-error' : ''; ?>" name="username" type="text" autofocus autocomplete="off" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>

                    <!-- password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                         <?php // Add error class ?>
                        <input tabindex="2" id="password" class="form-control form-input <?php echo !empty($errors) ? 'input-error' : ''; ?>" name="password" type="password" autocomplete="off">
                        <?php // Display error message using custom style ?>
                        <div class="error-message <?php echo !empty($errors) ? 'active' : ''; ?>" id="login-error" style="margin-top: 4px;">
                            <?php
                            if (!empty($errors)) {
                                echo htmlspecialchars(reset($errors)); // Display the first error
                            }
                            ?>
                        </div>
                    </div>

                    <!-- remember me -->
                    <div class="form-options d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input tabindex="3" id="rememberMe" name="rememberMe" type="checkbox" class="form-check-input">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <a href="forgot.php" tabindex="5" style="font-size: 14px;">Forgot Password?</a>
                    </div>

                    <!-- signin btn -->
                    <div class="form-buttons">
                        <button tabindex="4" class="btn submit-btn w-100" name="login" type="submit">Sign in</button>
                    </div>
                </form>

                <!-- try aw -->
                <div style="left: auto; font-size: 14px;">
                    <a href="#" id="try-another-way">Try Another Way</a>
                </div>

                <!-- register -->
                <div class="text-center mt-3 signup-link">
                    <span>New user? <a tabindex="6" href="register.php">Register</a></span>
                </div>
            </div>
        </div>
    </div>

</body>
</html>