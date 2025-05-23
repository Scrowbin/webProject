<?php
// Expects $errors, $post_data from controller.
$errors = $errors ?? [];
$post_data = $post_data ?? [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Forgot your MangaDax password? Enter your username or email to receive secure password reset instructions and regain access to your manga collection.">
    <meta name="keywords" content="manga, forgot password, reset password, MangaDax, account recovery, password help, lost password">
    <title>Forgot Password - MangaDax | Account Recovery</title>
    <link rel="icon" href="../IMG/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/register.css">
    <link rel="canonical" href="https://mangadax.local/forgot-password" />
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mangadax.local/forgot-password">
    <meta property="og:title" content="Forgot Password - MangaDax | Account Recovery">
    <meta property="og:description" content="Forgot your MangaDax password? Enter your username or email to receive secure password reset instructions.">
    <meta property="og:image" content="https://mangadax.local/IMG/logo.png">
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mangadax.local/forgot-password">
    <meta property="twitter:title" content="Forgot Password - MangaDax | Account Recovery">
    <meta property="twitter:description" content="Forgot your MangaDax password? Enter your username or email to receive secure password reset instructions.">
    <meta property="twitter:image" content="https://mangadax.local/IMG/logo.png">
    <style>
        .instruction-text {
            font-size: 13px;
            color: #aaa;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #444;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container login-page">
        <div class="page-header text-center py-4">
            <a href="../index.php" rel="nofollow">
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
                <form novalidate action="../forgot-password" method="post">
                    <div class="mb-3">
                        <label for="usernameOrEmail" class="form-label">Username or email</label>
                        <input tabindex="1" id="usernameOrEmail" class="form-control form-input <?php echo !empty($errors['credentials']) ? 'input-error' : ''; ?>" name="usernameOrEmail" type="text" required autofocus autocomplete="off" value="<?php echo isset($post_data['usernameOrEmail']) ? htmlspecialchars($post_data['usernameOrEmail']) : ''; ?>">
                        <div class="error-message <?php echo isset($errors['credentials']) ? 'active' : ''; ?>" id="forgot-error"><?php echo htmlspecialchars($errors['credentials'] ?? ''); ?></div>
                    </div>

                    <div class="mb-3">
                         <a href="../login" class="back-to-login">&laquo; Back to Login</a>
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

    <!-- Schema.org structured data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Forgot Password - MangaDax",
        "description": "Forgot your MangaDax password? Enter your username or email to receive secure password reset instructions.",
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
                    "name": "Forgot Password",
                    "item": "https://mangadax.local/forgot-password"
                }
            ]
        }
    }
    </script>
</body>
</html>