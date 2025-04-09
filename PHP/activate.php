<?php
// Include the controller and call the handler function
require_once __DIR__ . '/../controller/auth_controller.php';

// The handleActivate function returns message data for the view.
$viewData = handleActivate();

// Extract variables for easier access in the view
$message = $viewData['message'];
$message_type = $viewData['message_type'];

// --- The rest of the file is the View ---
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation</title>
    <link rel="icon" href="../IMG/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/register.css"> <!-- Reuse styling -->
    <style>
        body { background-color: #f8f9fa; }
        .activation-container { max-width: 500px; margin: 50px auto; padding: 30px; background-color: #1F2229; /* Match form bg */ border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; border-top: 2px solid #FF6740; /* Match form border */}
        /* Use CSS from register.css for logo */
    </style>
</head>
<body>
    <div class="container activation-container">
        <div class="page-header text-center py-4 mb-4">
            <a href="homepage.php" rel="nofollow">
                <div class="logo-container d-flex align-items-center justify-content-center">
                    <img src="../IMG/logo.png" alt="MangaDax Logo" style="height: 40px; margin-right: 10px;">
                    <span id="md-wordmark">MangaDax</span>
                </div>
            </a>
        </div>

        <h2 class="mb-4 text-white">Account Activation</h2>

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