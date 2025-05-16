<?php
require_once "../db/announcement_model.php";

// Get recent announcements (limit to 5)
$announcements = getAllAnnouncements(false, 5);

// Return as JSON
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'announcements' => $announcements
]);
