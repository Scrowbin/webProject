<?php
// require_once 'includes/db_config.php'; // Old path
require_once __DIR__ . '/../db/account_db.php'; // Includes db_config and $pdo
require_once __DIR__ . '/../db/account_db.php'; // Include the new account functions

$errors = [];
$success_message = '';
$activation_token_display = ''; // For debugging/testing activation

// Function to generate a secure token
function generate_token($length = 32) {
    // bin2hex converts binary data into hexadecimal representation
    return bin2hex(random_bytes($length));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $cf_password = $_POST['cf_password'] ?? '';
    $email = trim($_POST['email'] ?? '');

    // --- Validation ---

    // Username
    if (empty($username)) {
        $errors['username'] = 'Please specify user name.';
    } elseif (strlen($username) > 24) {
        $errors['username'] = 'Username cannot exceed 24 characters.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors['username'] = 'Username can only contain letters, numbers, and underscores.';
    }

    // Email
    if (empty($email)) {
        $errors['email'] = 'Please specify email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    // Password
    if (empty($password)) {
        $errors['password'] = 'Please specify password.';
    } elseif (strlen($password) < 8 || strlen($password) > 24) {
        $errors['password'] = 'Password must be between 8 and 24 characters.';
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[@$!%*?&]/', $password)) {
        $errors['password'] = 'Password must contain at least one letter, one number, and one special character (@$!%*?&).';
    }

    // Confirm Password
    if (empty($cf_password)) {
        $errors['cf_password'] = 'Please confirm your password.';
    } elseif ($password !== $cf_password) {
        $errors['cf_password'] = 'Passwords do not match.';
    }

    // --- Check for existing user/email if no validation errors so far ---
    if (empty($errors)) {
        if (account_check_username_exists($pdo, $username)) {
            $errors['username'] = 'Username already exists.';
        }
        if (empty($errors['email']) && account_check_email_exists($pdo, $email)) { // Check email only if no format error
             $errors['email'] = 'Email already registered.';
        }
    }

    // --- Process Registration if no errors ---
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $activation_token = generate_token();

        // Use the new function to add the account
        if (account_add($pdo, $username, $hashed_password, $email, $activation_token)) {
            // Registration successful
            // In a real application, send an email with the activation link here.
            // For now, display a success message and the token for testing.
            $activation_link = "http://localhost/phpCode/webProject/PHP/activate.php?token=" . $activation_token; // Adjust URL as needed
            $success_message = "Registration successful! Please check your email to activate your account.";
            // For testing purposes, show the link/token:
            $activation_token_display = "Activation Link (for testing): <a href='{$activation_link}'>{$activation_link}</a>";

            // Optionally redirect after a delay, or let the user click the link
            // header('Refresh: 5; URL=login.php'); // Redirect after 5 seconds

        } else {
            $errors['db'] = 'Registration failed. Please try again.'; // Generic error if add fails
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register MangaDax</title>
    <link rel="icon" href="favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/register.css">
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
                <h1>Create an Account</h1>
            </header>

            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success_message); ?><br>
                    <?php echo $activation_token_display; // Display activation link/token for testing ?>
                </div>
                 <div class="text-center mt-3">
                     <a href="login.php" class="btn btn-primary">Proceed to Login</a>
                 </div>
            <?php else: // Only show form if no success message ?>
            <div class="form-content">
                <form novalidate action="register.php" method="post">
                    <?php if (!empty($errors['db'])): ?>
                        <div class="mb-3 error-message active" style="text-align: center;"><?php echo htmlspecialchars($errors['db']); ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span class="required">*</span></label>
                        <input tabindex="1" id="username" class="form-control form-input <?php echo isset($errors['username']) ? 'input-error' : ''; ?>" name="username" type="text" required autocomplete="off" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        <div class="error-message <?php echo isset($errors['username']) ? 'active' : ''; ?>" id="username-error"><?php echo $errors['username'] ?? ''; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="required">*</span></label>
                        <input tabindex="2" id="password" class="form-control form-input <?php echo isset($errors['password']) ? 'input-error' : ''; ?>" name="password" type="password" required autocomplete="off">
                        <div class="error-message <?php echo isset($errors['password']) ? 'active' : ''; ?>" id="pwd-error"><?php echo $errors['password'] ?? ''; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="cf_password" class="form-label">Confirm Password <span class="required">*</span></label>
                        <input tabindex="3" id="cf_password" class="form-control form-input <?php echo isset($errors['cf_password']) ? 'input-error' : ''; ?>" name="cf_password" type="password" required autocomplete="off">
                        <div class="error-message <?php echo isset($errors['cf_password']) ? 'active' : ''; ?>" id="cfpwd-error"><?php echo $errors['cf_password'] ?? ''; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="required">*</span></label>
                        <input tabindex="4" id="email" class="form-control form-input <?php echo isset($errors['email']) ? 'input-error' : ''; ?>" name="email" type="email" required autocomplete="off" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        <div class="error-message <?php echo isset($errors['email']) ? 'active' : ''; ?>" id="email-error"><?php echo $errors['email'] ?? ''; ?></div>
                    </div>
                    <div class="mb-3">
                        <a href="login.php" class="back-to-login">&laquo; Back to Login</a>
                    </div>
                    <div class="form-buttons">
                        <button tabindex="5" class="btn submit-btn w-100" name="register" type="submit">Register</button>
                    </div>
                </form>
            </div>
            <?php endif; // End hiding form on success ?>
        </div>
    </div>
    <script src="../JS/register.js"></script>
</body>
</html>
