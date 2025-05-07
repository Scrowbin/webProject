<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and is an admin
$userID = $_SESSION['userID'] ?? null;
$username = $_SESSION['username'] ?? null;
$isLoggedIn = false;

if ($userID != null || $username != null) {
    $isLoggedIn = true;

    // Get user role
    require_once('../db/account_db.php');
    require_once('../db/mangaInfoPdo.php'); // Include for getUserID function

    // If userID is null but username is set, try to get userID from username
    if ($userID === null && $username !== null) {
        $userID = getUserID($username);
        $_SESSION['userID'] = $userID; // Update session
    }

    // Only check role if userID is not null
    if ($userID !== null) {
        $role = get_role((string)$userID); // Convert to string to ensure type safety

        // If not admin, redirect to homepage
        if ($role !== 'admin') {
            header('Location: ../index.php');
            exit("You must be an admin to access this page");
        }
    } else {
        // UserID is still null, redirect
        header('Location: ../index.php');
        exit("Unable to verify admin status. Please log in again.");
    }
} else {
    // Not logged in, redirect to homepage
    header('Location: ../index.php');
    exit("You must be logged in as an admin to access this page");
}

// Define path prefix for includes
$pathPrefix = '../';

// Include report model
require_once("../db/report_model.php");

// Include the report view page
include('../PHP/report_view.php');