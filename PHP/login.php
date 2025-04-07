<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in to MangaDax</title>
    <link rel="icon" href="../IMG/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/login.css">
    <script src="../JS/login.js"></script>
</head>
<body>
    <div class="container login-page">
        <div class="page-header text-center py-4">
            <a href="homepage.php" rel="nofollow">
                <div class="logo-container d-flex align-items-center justify-content-center">
                    <span id="md-logo" class="me-2"></span>
                    <span id="md-wordmark">MangaDax</span>
                </div>
            </a>
        </div>
        <div class="login-form-container p-4 rounded shadow">
            <header class="form-header text-center mb-4">
                <h1>Sign in to your account</h1>
            </header>
            <div class="form-content">
                <form novalidate onsubmit="return validInput()" class="login-form" action="" method="post">
                    <!-- username-->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username or email</label>
                        <input tabindex="1" id="username" class="form-control form-input" name="username" type="text" autofocus autocomplete="off">
                        <div class="error-message my-3" id="username-error">Invalid username or password</div>
                    </div>

                    <!-- password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input tabindex="2" id="password" class="form-control form-input" name="password" type="password" autocomplete="off">
                    </div>

                    <!-- remember me -->
                    <div class="form-options d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input tabindex="3" id="rememberMe" name="rememberMe" type="checkbox" class="form-check-input">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <a href="#" tabindex="5" style="font-size: 14px;">Forgot Password?</a>
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