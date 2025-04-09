<?php
// require_once 'includes/db_config.php'; // Old path
require_once __DIR__ . '/../db/account_db.php'; // Includes db_config and $pdo
require_once __DIR__ . '/../db/account_db.php'; // Include the new account functions

// Check for success message from forgot password page
$forgot_password_success = null;
if (isset($_SESSION['forgot_password_message'])) {
    $forgot_password_success = $_SESSION['forgot_password_message'];
    unset($_SESSION['forgot_password_message']); // Clear the message after displaying it once
}

// Redirect if already logged in
if (isset($_SESSION['username'])) {
    header('Location: homepage.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $usernameOrEmail = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    // $rememberMe = isset($_POST['rememberMe']); // Handle later if implementing remember me

    // Basic validation
    if (empty($usernameOrEmail)) {
        $errors['credentials'] = 'Please enter username or email.';
    } elseif (empty($password)) {
        $errors['credentials'] = 'Please enter password.';
    }

    if (empty($errors)) {
        // Use the new function to find the user
        $user = account_find_by_username_or_email($pdo, $usernameOrEmail);

        if ($user) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Check if account is activated
                if ($user['activated']) {
                    // Login successful
                    $_SESSION['username'] = $user['username'];
                    // Regenerate session ID for security
                    session_regenerate_id(true);

                    // Handle "Remember Me" - Simple example using cookies (needs more robust implementation for production)
                    /*
                    if ($rememberMe) {
                        $cookie_name = 'remember_user';
                        $cookie_value = base64_encode($user['username']); // Basic encoding
                        $expiry = time() + (86400 * 30); // 30 days
                        setcookie($cookie_name, $cookie_value, $expiry, "/"); // Set cookie for the whole domain
                    } else {
                        // Clear cookie if exists
                        if (isset($_COOKIE['remember_user'])) {
                            setcookie('remember_user', '', time() - 3600, "/");
                        }
                    }
                    */

                    header('Location: homepage.php');
                    exit;
                } else {
                    $errors['credentials'] = 'Account not activated. Please check your email.';
                }
            } else {
                // Invalid password
                $errors['credentials'] = 'Invalid username/email or password.';
            }
        } else {
            // User not found or DB error in function
            // The function logs errors, so just show generic message
            $errors['credentials'] = 'Invalid username/email or password.';
        }
    }
}

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

            <?php if (!empty($errors)):
                // commented out original error div
                /*
                <div class="alert alert-danger mb-3">
                    <?php 
                        // Display the first error found
                        echo htmlspecialchars(reset($errors)); 
                    ?>
                </div>
                */
            ?>
            <?php endif; ?>

            <div class="form-content">
                <form novalidate /* removed onsubmit="return validInput()" */ class="login-form" action="login.php" method="post">
                    <!-- username-->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username or email</label>
                        <input tabindex="1" id="username" class="form-control form-input <?php echo !empty($errors) ? 'input-error' : ''; ?>" name="username" type="text" autofocus autocomplete="off" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        <!-- Removed client-side validation div -->
                    </div>

                    <!-- password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input tabindex="2" id="password" class="form-control form-input <?php echo !empty($errors) ? 'input-error' : ''; ?>" name="password" type="password" autocomplete="off">
                         <!-- Add PHP error message display here -->
                        <div class="error-message <?php echo !empty($errors) ? 'active' : ''; ?>" id="login-error" style="margin-top: 4px;">
                            <?php 
                            if (!empty($errors)) {
                                echo htmlspecialchars(reset($errors)); // Display the first error found
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
                    <span>New user? <a tabindex="6" href="../PHP/register.php">Register</a></span>
                </div>
            </div>
        </div>
    </div>

</body>
</html>