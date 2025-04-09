<?php
// Include the controller and call the handler function
require_once __DIR__ . '/../controller/auth_controller.php';

// The handleRegister function will return data needed for the view.
$viewData = handleRegister();

// Extract variables for easier access in the view
$errors = $viewData['errors'];
$success_data = $viewData['success_data']; // Contains message and activation_link_html on success
// $post_data = $viewData['post_data'] ?? []; // Use this if you want to repopulate form on error

// --- The rest of the file is the View ---
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register MangaDax</title>
    <link rel="icon" href="../IMG/favicon.ico">
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

            <?php if ($success_data): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success_data['message']); ?><br>
                    <?php echo $success_data['activation_link_html']; // Display activation link/token for testing ?>
                </div>
                 <div class="text-center mt-3">
                     <a href="login.php" class="btn btn-primary">Proceed to Login</a>
                 </div>
            <?php else: // Only show form if no success message ?>
            <div class="form-content">
                <form novalidate action="register.php" method="post">
                    <?php // Display generic DB error ?>
                    <?php if (!empty($errors['db'])): ?>
                        <div class="mb-3 error-message active" style="text-align: center;"><?php echo htmlspecialchars($errors['db']); ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span class="required">*</span></label>
                        <?php // Add error class, retain value using $post_data if needed ?>
                        <input tabindex="1" id="username" class="form-control form-input <?php echo isset($errors['username']) ? 'input-error' : ''; ?>" name="username" type="text" required autocomplete="off" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; /* Or use $post_data */ ?>">
                        <div class="error-message <?php echo isset($errors['username']) ? 'active' : ''; ?>" id="username-error"><?php echo $errors['username'] ?? ''; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="required">*</span></label>
                         <?php // Add error class ?>
                        <input tabindex="2" id="password" class="form-control form-input <?php echo isset($errors['password']) ? 'input-error' : ''; ?>" name="password" type="password" required autocomplete="off">
                        <div class="error-message <?php echo isset($errors['password']) ? 'active' : ''; ?>" id="pwd-error"><?php echo $errors['password'] ?? ''; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="cf_password" class="form-label">Confirm Password <span class="required">*</span></label>
                        <?php // Add error class ?>
                        <input tabindex="3" id="cf_password" class="form-control form-input <?php echo isset($errors['cf_password']) ? 'input-error' : ''; ?>" name="cf_password" type="password" required autocomplete="off">
                        <div class="error-message <?php echo isset($errors['cf_password']) ? 'active' : ''; ?>" id="cfpwd-error"><?php echo $errors['cf_password'] ?? ''; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="required">*</span></label>
                         <?php // Add error class, retain value ?>
                        <input tabindex="4" id="email" class="form-control form-input <?php echo isset($errors['email']) ? 'input-error' : ''; ?>" name="email" type="email" required autocomplete="off" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; /* Or use $post_data */?>">
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
    <?php /* Removed register.js script link - Server side validation is primary */ ?>
</body>
</html>
