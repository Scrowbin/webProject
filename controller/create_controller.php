<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $userID = $_SESSION['userID'] ?? null;
    $username = $_SESSION['username'] ?? null;
    $isLoggedIn = false;
    if ($userID !=null || $username!= null){
        $isLoggedIn =true;
    }

    if (!$isLoggedIn){
        exit("You must be logged in as an admin");
    }

    // Define path prefix for includes
    $pathPrefix = '../';

    include("../PHP/create.php");
    // Upload via AJAX
?>
