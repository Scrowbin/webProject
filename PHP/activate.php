<?php
// Expects $message and $message_type from controller.
$message = $message ?? 'Activation status unknown.';
$message_type = $message_type ?? 'info';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Activate your MangaDax account to access thousands of manga titles, track your reading progress, and join our vibrant manga community.">
    <meta name="keywords" content="manga, account activation, verify account, MangaDax, manga reader, manga community">
    <title>Account Activation - MangaDax | Verify Your Account</title>
    <link rel="icon" href="../IMG/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/register.css">
    <link rel="canonical" href="https://mangadax.local/activate" />
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mangadax.local/activate">
    <meta property="og:title" content="Account Activation - MangaDax | Verify Your Account">
    <meta property="og:description" content="Activate your MangaDax account to access thousands of manga titles and join our community.">
    <meta property="og:image" content="https://mangadax.local/IMG/logo.png">
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mangadax.local/activate">
    <meta property="twitter:title" content="Account Activation - MangaDax | Verify Your Account">
    <meta property="twitter:description" content="Activate your MangaDax account to access thousands of manga titles and join our community.">
    <meta property="twitter:image" content="https://mangadax.local/IMG/logo.png">
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
    <div class="container activation-container">
        <div class="page-header text-center py-4">
            <a href="../index.php" rel="nofollow">
                <div class="logo-container d-flex align-items-center justify-content-center">
                    <img src="../IMG/logo.png" alt="MangaDax Logo" style="height: 40px; margin-right: 10px;">
                    <span id="md-wordmark">MangaDax</span>
                </div>
            </a>
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
                <a href="../login" class="btn btn-primary">Go to Login</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Schema.org structured data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Account Activation - MangaDax",
        "description": "Activate your MangaDax account to access thousands of manga titles and join our community.",
        "publisher": {
            "@type": "Organization",
            "name": "MangaDax",
            "logo": {
                "@type": "ImageObject",
                "url": "https://mangadax.local/IMG/logo.png"
            }
        },
        "breadcrumb": {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "https://mangadax.local/"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Account Activation",
                    "item": "https://mangadax.local/activate"
                }
            ]
        }
    }
    </script>
</body>
</html>