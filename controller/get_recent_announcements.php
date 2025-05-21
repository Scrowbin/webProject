<?php
require_once "../db/announcement_model.php";

// Get recent announcements (limit to 5)
$announcements = getAllAnnouncements(false, 5);

// Format dates for each announcement
foreach ($announcements as &$announcement) {
    if (isset($announcement['created_at'])) {
        $announcement['created_at'] = date('Y-m-d H:i:s', strtotime($announcement['created_at']));
    }
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'announcements' => $announcements
]);
