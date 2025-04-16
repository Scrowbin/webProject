<?php
// This file displays a login required message
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Required - MangaDax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="../CSS/navbar.css">
    <style>
        body {
            background-color: #1f1f1f;
            color: #e0e0e0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .login-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
        }
        .btn-signin {
            background-color: #FF6740;
            color: white;
            border: none;
            font-weight: bold;
            padding: 0.5rem 2rem;
            margin-right: 0.5rem;
            transition: background-color 0.2s ease;
        }
        .btn-signin:hover {
            background-color: #e65c30;
            color: white;
        }
        .btn-register {
            background-color: #444;
            color: white;
            border: none;
            font-weight: bold;
            padding: 0.5rem 2rem;
            transition: background-color 0.2s ease;
        }
        .btn-register:hover {
            background-color: #555;
            color: white;
        }
        .login-message {
            margin-bottom: 2rem;
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="login-container">
        <h3 class="login-message">You need to sign in to access this page.</h3>
        <div>
            <a href="<?= $pathPrefix ?>controller/auth_controller.php?action=login" class="btn btn-signin">Sign In</a>
            <a href="<?= $pathPrefix ?>controller/auth_controller.php?action=register" class="btn btn-register">Register</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/navbar.js"></script>
</body>
</html>
