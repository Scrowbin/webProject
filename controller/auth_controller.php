<?php
// Authentication Controller: Handles login, registration, activation, etc.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../db/account_db.php';

// --- Handler Functions ---

function handleLogin(): void
{
    global $errors, $forgot_password_success, $post_data;

    if (isset($_SESSION['forgot_password_message'])) {
        $forgot_password_success = $_SESSION['forgot_password_message'];
        unset($_SESSION['forgot_password_message']);
    }

    if (isset($_SESSION['username'])) { 
        header('Location: ../index.php'); 
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $usernameOrEmail = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $post_data = $_POST;

        if (empty($usernameOrEmail)) {
            $errors['credentials'] = 'Please enter username or email.';
        } elseif (empty($password)) {
            $errors['credentials'] = 'Please enter password.';
        }

        if (empty($errors)) {
            $user = account_find_by_username_or_email($usernameOrEmail); 

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    if ($user['activated']) {
                        $_SESSION['username'] = $user['username']; 
                        session_regenerate_id(true);

                        // --- Redirect back using session or fallback ---
                        $redirectUrl = $_SESSION['login_return_url'] ?? '../index.php';
                        unset($_SESSION['login_return_url']); // Clear after use
                        
                        // Basic check to prevent redirection loops to auth controller itself
                        if (str_contains($redirectUrl, 'auth_controller.php')) {
                             $redirectUrl = '../index.php';
                        }
                        header("Location: " . $redirectUrl); 
                        // --- End Redirect logic ---
                        exit;
                    } else {
                        $errors['credentials'] = 'Account not activated. Please check your email.';
                        unset($_SESSION['login_return_url']); // Clear on activation error
                    }
                } else {
                    $errors['credentials'] = 'Invalid username/email or password.';
                    unset($_SESSION['login_return_url']); // Clear on password error
                }
            } else {
                $errors['credentials'] = 'Invalid username/email or password.';
                unset($_SESSION['login_return_url']); // Clear on user not found error
            }
        }
    }
}

function generate_token(int $length = 32): string
{
    return bin2hex(random_bytes($length));
}

function handleRegister(): void
{
    global $errors, $success_data, $post_data;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $cf_password = $_POST['cf_password'] ?? '';
        $email = trim($_POST['email'] ?? '');
        $post_data = $_POST;

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

            $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $host = $_SERVER['HTTP_HOST'];
            $script_path = $_SERVER['SCRIPT_NAME'];
            $activation_link = "{$scheme}://{$host}{$script_path}?action=activate&token=" . $activation_token;

            if (account_add($username, $hashed_password, $email, $activation_token)) {
                if (user_add($username)) { 
                    $success_data = [
                        'message' => "Registration successful! Please check your email to activate your account.",
                        'activation_link_html' => "Activation Link (for testing): <a href='{$activation_link}'>{$activation_link}</a>"
                    ];
                    $post_data = []; 
                    // TODO: Implement actual email sending for activation link
                    error_log("Activation link for {$username}: {$activation_link}"); // For testing
                } else {
                    $errors['db'] = 'Registration partially failed (user record). Please contact support.';
                    error_log("CRITICAL: Failed to add user record for Username: {$username}");
                }
            } else {
                $errors['db'] = 'Registration failed. Please try again.';
            }
        }
    }
}

function handleActivate(): void
{
    global $message, $message_type;

    $token = $_GET['token'] ?? '';

    if (empty($token)) {
        $message = 'Activation token is missing.';
        $message_type = 'danger';
    } else {
        $user = account_find_by_token($token);
        if (!$user) {
            $message = 'Invalid or expired activation token.';
            $message_type = 'danger';
        } elseif ($user['activated']) {
            $message = 'Account already activated.';
            $message_type = 'warning';
        } else {
            if (account_activate($token)) {
                $message = 'Account successfully activated! You can now log in.';
                $message_type = 'success';
            } else {
                $message = 'Failed to activate account. Please try again or contact support.';
                $message_type = 'danger';
            }
        }
    }
}

function handleForgotPassword(): void
{
    global $errors, $post_data;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $usernameOrEmail = trim($_POST['usernameOrEmail'] ?? '');
        $post_data = $_POST;

        if (empty($usernameOrEmail)) {
            $errors['credentials'] = 'Please enter your username or email.';
        } else {
            $user = account_find_by_username_or_email($usernameOrEmail);
            if ($user) {
                 // TODO: Implement password reset token generation, storage, and email sending.
                 error_log("Password reset requested for user: " . $user['username']); 
                 $_SESSION['forgot_password_message'] = "If an account with that username or email exists, password reset instructions have been sent.";
                 header("Location: auth_controller.php?action=login");
                 exit;
            } else {
                $errors['credentials'] = 'Username or email not found.'; 
            }
        }
    }
}

function handleProfile(): void
{
    global $user_data;

    if (!isset($_SESSION['username'])) { 
        header("Location: auth_controller.php?action=login");
        exit;
    }

    $username = $_SESSION['username'];
    $user_data = account_find_by_username($username);

    if (!$user_data) {
        session_unset();
        session_destroy();
        header("Location: auth_controller.php?action=login&message=Profile+data+not+found.");
        exit;
    }
}

function handleUpdateProfile(): void {
    global $user_data, $profile_update_message, $profile_errors;

    if (!isset($user_data)) { 
         header("Location: auth_controller.php?action=login");
         exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $dob = $_POST['DOB'] ?? null;
         $location = trim($_POST['location'] ?? '');
         $website = trim($_POST['website'] ?? '');
         $about = trim($_POST['userText'] ?? '');

         // --- TODO: Add Server-Side Validation for Profile Fields ---
         // Example: $profile_errors['dob'] = 'Invalid date format';

         if(empty($profile_errors)) {
             // --- TODO: Implement Database Update for Profile --- 
             // Requires a model function like account_update_profile($_SESSION['username'], $updateData)
             // This function would update fields in 'account' and/or 'user' table.
             $profile_update_message = "Profile update submitted (Backend logic needed)."; // Placeholder message
             // Optionally: Refresh $user_data after successful update
             // $user_data = account_find_by_username($_SESSION['username']);
         }
    }
}

// --- Initialize View Variables ---
$errors = [];
$post_data = [];
$forgot_password_success = null;
$success_data = null;
$message = '';
$message_type = 'info';
$user_data = null;
$profile_update_message = null;
$profile_errors = [];

// --- Routing ---
$action = $_GET['action'] ?? 'login';

switch ($action) {
    case 'login':
        // --- Store return URL on GET request ---
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $referer = $_SERVER['HTTP_REFERER'] ?? null;
            $host = $_SERVER['HTTP_HOST'];
            if ($referer) {
                $refererHost = parse_url($referer, PHP_URL_HOST);
                $refererPath = parse_url($referer, PHP_URL_PATH) ?? '';
                 // Check if referer is on the same host and not an auth page itself
                if ($refererHost && $refererHost === $host && !str_contains($refererPath, 'auth_controller.php')) {
                    $_SESSION['login_return_url'] = $referer;
                    // error_log("Stored login return URL: " . $_SESSION['login_return_url']); // For debugging
                }
            }
        }
        // --- End Store return URL ---
        handleLogin();
        // Clear return URL if login fails (errors exist)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($errors)) {
            unset($_SESSION['login_return_url']);
        }
        include __DIR__ . '/../PHP/login.php';
        break;
    case 'register':
        handleRegister();
        include __DIR__ . '/../PHP/register.php';
        break;
    case 'activate':
        handleActivate();
        $activate_view = __DIR__ . '/../PHP/activate.php';
        if (file_exists($activate_view)) {
            include $activate_view;
        } else {
             echo "<h1>Account Activation</h1><p class='alert alert-" . ($message_type === 'success' ? 'success' : 'danger') . "'>" . htmlspecialchars($message) . "</p><a href='auth_controller.php?action=login'>Go to Login</a>";
             error_log("Activation view not found: " . $activate_view);
        }
        break;
    case 'forgotPassword':
        handleForgotPassword();
        include __DIR__ . '/../PHP/forgot.php';
        break;
    case 'profile':
        handleProfile();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             handleUpdateProfile();
        }
        include __DIR__ . '/../PHP/profile.php';
        break;
    case 'logout':
        // --- Redirect back logic for logout ---
        $referer = $_SERVER['HTTP_REFERER'] ?? null;
        $fallbackUrl = '../index.php';
        $host = $_SERVER['HTTP_HOST'];
        $redirectUrl = $fallbackUrl;

        if ($referer) {
            $refererHost = parse_url($referer, PHP_URL_HOST);
            if ($refererHost && $refererHost === $host) {
                 // Avoid redirecting back to auth pages after logout
                if (!str_contains(parse_url($referer, PHP_URL_PATH), 'auth_controller.php')) {
                     $redirectUrl = $referer;
                }
            }
        }
        // Append logout message
        $redirectUrl .= (str_contains($redirectUrl, '?') ? '&' : '?') . 'message=Logged+out';
        // --- End Redirect logic ---

        session_unset();
        session_destroy();
        header("Location: " . $redirectUrl); 
        exit;
    default:
        header("Location: auth_controller.php?action=login");
        exit;
}

?> 