<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../db/announcement_model.php";
header('Content-Type: application/json');

$response = [];

try {
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

            // If not admin, return error
            if ($role !== 'admin') {
                throw new Exception("You must be an admin to post announcements");
            }
        } else {
            // UserID is still null
            throw new Exception("Unable to verify admin status. Please log in again.");
        }
    } else {
        // Not logged in, return error
        throw new Exception("You must be logged in as an admin to post announcements");
    }

    // Check request method
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }

    // Get announcement content
    $content = trim($_POST["content"] ?? '');
    $expireAt = !empty($_POST["expire_at"]) ? $_POST["expire_at"] : null;

    // Validate content
    if (empty($content)) {
        throw new Exception("Announcement content cannot be empty.");
    }

    // Deactivate all existing announcements first
    deactivateAllAnnouncements();

    // Create new announcement
    $announcementID = createAnnouncement($content, $expireAt);

    $response = [
        'success' => true,
        'message' => "Announcement posted successfully! All previous announcements have been deactivated.",
        'announcementID' => $announcementID
    ];

} catch (Exception $e) {
    http_response_code(400); // Bad request
    $response = [
        'success' => false,
        'error' => $e->getMessage()
    ];
}

echo json_encode($response);
