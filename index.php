<?php
// webProject/index.php - Homepage Controller

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary base files
require_once __DIR__ . '/db/pdo.php'; 
require_once __DIR__ . '/db/mangaInfoPdo.php'; // Contains get_manga_basic_info

// --- Data Fetching for Homepage ---
$pdo = pdo_get_connection(); 
$featuredManga = get_manga_details_for_homepage(1); // Use the new function to get all details

// --- Prepare View Data (Example, you might pass more) ---
$viewData = [
    'featuredManga' => $featuredManga ?? null // Pass featured manga to the view
];

// --- Include the Homepage View ---
// Make viewData available to the included file
if (isset($viewData)) {
    extract($viewData);
}
include __DIR__ . '/PHP/homepage.php';

?>
