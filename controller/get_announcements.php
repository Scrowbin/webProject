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
        
        // If not admin, return empty array
        if ($role !== 'admin') {
            header('Content-Type: application/json');
            echo json_encode([]);
            exit;
        }
    } else {
        // UserID is still null, return empty array
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }
} else {
    // Not logged in, return empty array
    header('Content-Type: application/json');
    echo json_encode([]);
    exit;
}

// Get all announcements
require_once('../db/announcement_model.php');
$announcements = getAllAnnouncements();

// Return as JSON
header('Content-Type: application/json');
echo json_encode($announcements);
