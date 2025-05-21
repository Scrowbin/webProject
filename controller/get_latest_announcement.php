<?php
require_once "../db/announcement_model.php";

// Get the latest active announcement
$announcement = getLatestActiveAnnouncement();

// Format date if announcement exists
if ($announcement && isset($announcement['created_at'])) {
    $announcement['created_at'] = date('Y-m-d H:i:s', strtotime($announcement['created_at']));
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'hasAnnouncement' => !empty($announcement),
    'announcement' => $announcement
]);
