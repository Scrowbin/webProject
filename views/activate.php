<?php
// Expects $message and $message_type from controller.
$message = $message ?? 'Activation status unknown.';
$message_type = $message_type ?? 'info';
$hide_auth_nav = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Email verification for <?= htmlspecialchars(site_title()) ?> — student project accounts only.">
    <title>Account activation — <?= htmlspecialchars(site_title()) ?></title>
    <link rel="icon" href="/assets/static/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/register.css">
    <link rel="stylesheet" href="/assets/css/site-identity.css">
    <link rel="canonical" href="<?= htmlspecialchars(app_url('/activate')) ?>" />
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars(app_url('/activate')) ?>">
    <meta property="og:title" content="Account Activation - MangaDax | Verify Your Account">
    <meta property="og:description" content="Activate your MangaDax account to access thousands of manga titles and join our community.">
    <meta property="og:image" content="<?= htmlspecialchars(app_url('/assets/static/logo.png')) ?>">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= htmlspecialchars(app_url('/activate')) ?>">
    <meta property="twitter:title" content="Account Activation - MangaDax | Verify Your Account">
    <meta property="twitter:description" content="Activate your MangaDax account to access thousands of manga titles and join our community.">
    <meta property="twitter:image" content="<?= htmlspecialchars(app_url('/assets/static/logo.png')) ?>">
    <style>
        .activation-container {
            max-width: 600px;
            margin-top: 50px;
        }
        .activation-card {
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background-color: #2c2c2c;
        }
        .activation-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .alert-success { color: #198754; background-color: #d1e7dd; border-color: #badbcc; }
        .alert-danger { color: #dc3545; background-color: #f8d7da; border-color: #f5c2c7; }
        .alert-warning { color: #ffc107; background-color: #fff3cd; border-color: #ffe69c; }
        .alert-info { color: #0dcaf0; background-color: #cff4fc; border-color: #b6effb; }

    </style>
</head>
<body>
    <?php include __DIR__ . '/includes/site_identity_bar.php'; ?>
    <div class="container activation-container">
        <div class="page-header text-center py-4">
            <a href="<?= htmlspecialchars(app_url('/')) ?>">
                <div class="logo-container d-flex align-items-center justify-content-center">
                    <img src="/assets/static/logo.png" alt="<?= htmlspecialchars(site_name()) ?> logo" style="height: 40px; margin-right: 10px;">
                    <span id="md-wordmark"><?= htmlspecialchars(site_name()) ?></span>
                </div>
            </a>
        </div>
        <div class="auth-page-context text-center mb-3">
            <nav class="auth-page-nav justify-content-center">
                <a href="<?= htmlspecialchars(app_url('/')) ?>"><i class="bi bi-house-door"></i> Back to home</a>
                <a href="<?= htmlspecialchars(app_url('/about')) ?>">About</a>
            </nav>
        </div>

        <div class="activation-card text-center">
            <?php
                $icon_class = 'bi-info-circle';
                if ($message_type === 'success') {
                    $icon_class = 'bi-check-circle-fill text-success';
                } elseif ($message_type === 'danger') {
                    $icon_class = 'bi-exclamation-triangle-fill text-danger';
                } elseif ($message_type === 'warning') {
                    $icon_class = 'bi-exclamation-triangle-fill text-warning';
                }
            ?>
            <i class="bi <?php echo $icon_class; ?> activation-icon"></i>

            <h1>Account Activation</h1>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?> mt-3" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>

            <div class="mt-4">
                <a href="<?= htmlspecialchars(app_url('/login')) ?>" class="btn btn-primary">Go to sign in</a>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/includes/site_footer_disclaimer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>