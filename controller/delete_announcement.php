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
                throw new Exception("You must be an admin to delete announcements");
            }
        } else {
            // UserID is still null
            throw new Exception("Unable to verify admin status. Please log in again.");
        }
    } else {
        // Not logged in, return error
        throw new Exception("You must be logged in as an admin to delete announcements");
    }

    // Check request method
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }

    // Get JSON data
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Check if announcementID is provided
    if (!isset($data['announcementID']) || empty($data['announcementID'])) {
        throw new Exception("Announcement ID is required.");
    }

    $announcementID = (int)$data['announcementID'];

    // Delete the announcement
    $success = deleteAnnouncement($announcementID);

    if (!$success) {
        throw new Exception("Failed to delete announcement.");
    }

    $response = [
        'success' => true,
        'message' => "Announcement deleted successfully!"
    ];

} catch (Exception $e) {
    http_response_code(400); // Bad request
    $response = [
        'success' => false,
        'error' => $e->getMessage()
    ];
}

echo json_encode($response);
