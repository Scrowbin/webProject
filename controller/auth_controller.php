<?php
// This controller handles login, registration, activation, forgot password etc.

// Always start session here as controllers are entry points
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary model and configuration files
require_once __DIR__ . '/../db/account_db.php'; // Includes db_config & pdo functions

/**
 * Handles the login process.
 * Checks request method, validates data, authenticates user, and redirects or prepares data for the view.
 * @return array An array containing data for the view (e.g., errors, forgot_password_success)
 */
function handleLogin(): array
{
    $errors = [];
    $forgot_password_success = null;

    // Check for success message from forgot password redirect
    if (isset($_SESSION['forgot_password_message'])) {
        $forgot_password_success = $_SESSION['forgot_password_message'];
        unset($_SESSION['forgot_password_message']);
    }

    // Redirect if already logged in
    if (isset($_SESSION['username'])) {
        header('Location: homepage.php');
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $usernameOrEmail = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // --- Validation ---
        if (empty($usernameOrEmail)) {
            $errors['credentials'] = 'Please enter username or email.';
        } elseif (empty($password)) {
            $errors['credentials'] = 'Please enter password.';
        }

        // --- Authentication ---
        if (empty($errors)) {
            $user = account_find_by_username_or_email($usernameOrEmail);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    if ($user['activated']) {
                        // Login successful
                        $_SESSION['username'] = $user['username'];
                        session_regenerate_id(true);
                        header('Location: homepage.php');
                        exit;
                    } else {
                        $errors['credentials'] = 'Account not activated. Please check your email.';
                    }
                } else {
                    $errors['credentials'] = 'Invalid username/email or password.';
                }
            } else {
                $errors['credentials'] = 'Invalid username/email or password.';
            }
        }
        // If login fails, the script continues and will include the view with $errors populated.
    }

    // Return data needed by the view (even if it's just empty arrays/null)
    return [
        'errors' => $errors,
        'forgot_password_success' => $forgot_password_success
    ];
}

/**
 * Generates a secure token.
 * @param int $length
 * @return string
 */
function generate_token(int $length = 32): string
{
    return bin2hex(random_bytes($length));
}

/**
 * Handles the registration process.
 * Validates input, checks for existing user/email, adds user to DB, and prepares data for the view.
 * @return array An array containing data for the view (e.g., errors, success_data)
 */
function handleRegister(): array
{
    $errors = [];
    $success_data = null; // Will contain message and activation link on success

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $cf_password = $_POST['cf_password'] ?? '';
        $email = trim($_POST['email'] ?? '');

        // --- Validation ---
        if (empty($username)) {
            $errors['username'] = 'Please specify user name.';
        } elseif (strlen($username) > 24) {
            $errors['username'] = 'Username cannot exceed 24 characters.';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors['username'] = 'Username can only contain letters, numbers, and underscores.';
        }

        if (empty($email)) {
            $errors['email'] = 'Please specify email.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
        }

        if (empty($password)) {
            $errors['password'] = 'Please specify password.';
        } elseif (strlen($password) < 8 || strlen($password) > 24) {
            $errors['password'] = 'Password must be between 8 and 24 characters.';
        } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[@$!%*?&]/', $password)) {
            $errors['password'] = 'Password must contain at least one letter, one number, and one special character (@$!%*?&).';
        }

        if (empty($cf_password)) {
            $errors['cf_password'] = 'Please confirm your password.';
        } elseif ($password !== $cf_password) {
            $errors['cf_password'] = 'Passwords do not match.';
        }

        // --- Check for existing user/email ---
        if (empty($errors)) {
            if (account_check_username_exists($username)) {
                $errors['username'] = 'Username already exists.';
            }
            if (empty($errors['email']) && account_check_email_exists($email)) {
                $errors['email'] = 'Email already registered.';
            }
        }

        // --- Process Registration ---
        if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $activation_token = generate_token();

            if (account_add($username, $hashed_password, $email, $activation_token)) {
                // Registration successful
                $activation_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 2) . "/PHP/activate.php?token=" . $activation_token; // Generate dynamic link
                $success_data = [
                    'message' => "Registration successful! Please check your email to activate your account.",
                    'activation_link_html' => "Activation Link (for testing): <a href='{$activation_link}'>{$activation_link}</a>"
                ];
                 // Clear form data on success by not returning it
            } else {
                $errors['db'] = 'Registration failed. Please try again.';
            }
        }
        // If registration fails or it's a GET request, the script continues to the view
    }

    // Return data for the view
    return [
        'errors' => $errors,
        'success_data' => $success_data
        // Optionally return $_POST data here if you want to repopulate the form on validation errors
        // 'post_data' => $_POST
    ];
}

/**
 * Handles account activation.
 * Gets token from query string, calls model function, and returns message data for the view.
 * @return array An array containing message and message_type for the view.
 */
function handleActivate(): array
{
    $message = '';
    $message_type = 'danger'; // Default to error
    $token = $_GET['token'] ?? '';

    if (empty($token)) {
        $message = 'Activation token is missing.';
    } else {
        $user = account_find_by_token($token); // Use model function

        if (!$user) {
            $message = 'Invalid or expired activation token.';
        } elseif ($user['activated']) {
            $message = 'Account already activated.';
            $message_type = 'warning';
        } else {
            if (account_activate($token)) { // Use model function
                $message = 'Account successfully activated! You can now log in.';
                $message_type = 'success';
            } else {
                $message = 'Failed to activate account. Please try again or contact support.';
            }
        }
    }

    return [
        'message' => $message,
        'message_type' => $message_type
    ];
}

/**
 * Handles the forgot password request.
 * Validates input, sets session message, and redirects to login page.
 * @return array An array containing data for the view (e.g., errors)
 */
function handleForgotPassword(): array
{
    $errors = [];
    // Success message is handled via session redirect

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $usernameOrEmail = trim($_POST['usernameOrEmail'] ?? '');

        if (empty($usernameOrEmail)) {
            $errors['credentials'] = 'Please enter your username or email.';
        } else {
            // --- Placeholder for actual reset logic ---
            // In a real implementation:
            // 1. Find user by username or email.
            // 2. If found, generate and store reset token.
            // 3. Send email with reset link.
            // --- End Placeholder ---

            // Regardless of whether user was found, set session message and redirect
            $_SESSION['forgot_password_message'] = "You should receive an email shortly with further instructions.";
            header("Location: login.php");
            exit;
        }
        // If validation fails, the script continues to the view with $errors
    }

    // Return data for the view
    return [
        'errors' => $errors
        // 'post_data' => $_POST // Optionally return POST data
    ];
}

/**
 * Handles the profile page display.
 * Checks login status and fetches user data for the view.
 * @return array An array containing user data or null if not logged in/error.
 */
function handleProfile(): ?array
{
    // Check if the user is logged in, if not then redirect to login page
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

    // Fetch user data based on session username
    $username = $_SESSION['username'];
    $user_data = account_find_by_username($username);

    // If user data couldn't be fetched (e.g., user deleted while session active)
    if (!$user_data) {
        // Optionally clear session and redirect to login
        session_unset();
        session_destroy();
        header("Location: login.php?message=Profile data not found.");
        exit;
    }

    // Return user data for the view
    return $user_data;
}

?> 