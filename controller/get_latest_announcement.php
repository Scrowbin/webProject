<?php
require_once "../db/announcement_model.php";

// Get the latest active announcement
$announcement = getLatestActiveAnnouncement();

// Return as JSON
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'hasAnnouncement' => !empty($announcement),
    'announcement' => $announcement
]);
