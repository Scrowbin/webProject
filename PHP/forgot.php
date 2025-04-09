<?php
// Include the controller and call the handler function
require_once __DIR__ . '/../controller/auth_controller.php';

// The handleForgotPassword function will either redirect or return errors.
$viewData = handleForgotPassword();

// Extract variables for easier access in the view
$errors = $viewData['errors'];
// $post_data = $viewData['post_data'] ?? [];

// Success message is handled on the login page after redirect.

// --- The rest of the file is the View ---
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - MangaDax</title>
    <link rel="icon" href="../IMG/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/register.css"> <!-- Use register.css for consistent styling -->
    <style>
        /* Add specific styles if needed, or modify register.css */
        .instruction-text {
            font-size: 13px; /* Slightly smaller */
            color: #aaa; /* Even lighter grey */
            margin-top: 20px; /* More space above */
            padding-top: 15px; /* Space for the border */
            border-top: 1px solid #444; /* Faint top border for separation */
            text-align: center;
        }
    </style>
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
                <h1>Forgot Your Password?</h1>
            </header>

            <div class="form-content">
                <form novalidate action="forgot.php" method="post">
                    <div class="mb-3">
                        <label for="usernameOrEmail" class="form-label">Username or email</label>
                        <input tabindex="1" id="usernameOrEmail" class="form-control form-input <?php echo !empty($errors['credentials']) ? 'input-error' : ''; ?>" name="usernameOrEmail" type="text" required autofocus autocomplete="off" value="<?php echo isset($_POST['usernameOrEmail']) ? htmlspecialchars($_POST['usernameOrEmail']) : ''; /* Or use $post_data */ ?>">
                        <div class="error-message <?php echo isset($errors['credentials']) ? 'active' : ''; ?>" id="forgot-error"><?php echo $errors['credentials'] ?? ''; ?></div>
                    </div>

                    <div class="mb-3">
                         <a href="login.php" class="back-to-login">&laquo; Back to Login</a>
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
</body>
</html> 