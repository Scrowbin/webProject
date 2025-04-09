<?php
// require_once 'includes/db_config.php'; // Old path
require_once __DIR__ . '/../db/account_db.php'; // Includes db_config and $pdo
require_once __DIR__ . '/../db/account_db.php'; // Include the new account functions

$message = '';
$message_type = 'danger'; // Default to error
$token = $_GET['token'] ?? '';

if (empty($token)) {
    $message = 'Activation token is missing.';
} else {
    // Use the new function to find the user by token
    $user = account_find_by_token($pdo, $token);

    if (!$user) {
        $message = 'Invalid or expired activation token.';
    } elseif ($user['activated']) {
        $message = 'Account already activated.';
        $message_type = 'warning';
    } else {
        // Use the new function to activate the account
        if (account_activate($pdo, $token)) {
            $message = 'Account successfully activated! You can now log in.';
            $message_type = 'success';
        } else {
            $message = 'Failed to activate account. Please try again or contact support.';
            // Keep $message_type as default 'danger'
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation</title>
    <link rel="icon" href="favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/login.css"> <!-- Reuse login CSS or create a specific one -->
    <style>
        /* Minimal styling for activation page */
        body { background-color: #f8f9fa; }
        .activation-container { max-width: 500px; margin: 50px auto; padding: 30px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
        .logo-container span { color: #ff6740; /* Example color */ font-size: 1.8rem; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container activation-container">
        <div class="page-header text-center py-4">
            <a href="homepage.php" rel="nofollow">
                <div class="logo-container d-flex align-items-center justify-content-center">
                    <!-- You might want a logo here -->
                    <span id="md-wordmark">MangaDax</span>
                </div>
            </a>
        </div>

        <h2 class="mb-4">Account Activation</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($message_type === 'success' || $message_type === 'warning'): ?>
            <a href="login.php" class="btn btn-primary mt-3">Go to Login</a>
        <?php endif; ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 