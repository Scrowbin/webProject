<?php
// webProject/index.php - Homepage Controller

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary base files
require_once __DIR__ . '/db/pdo.php';
require_once __DIR__ . '/db/mangaInfoPdo.php'; // Contains getMangaInfo, getTags, getMangaAuthors, getMangaArtists

// --- Data Fetching for Homepage ---

// Simplified approach to avoid SQL errors
$allManga = [];

// Fetch manga with ID 1 (Zeikin de Katta Hon)
$allManga[1] = getMangaInfo(1);

// Fetch manga with ID 2 (Kaoru Hana wa Rin to Saku)
$allManga[2] = getMangaInfo(2);

// Fetch manga with ID 3 (Sousou no Frieren)
$allManga[3] = getMangaInfo(3);

// Get tags for each manga
foreach ($allManga as $id => $manga) {
    if ($manga) {
        $allManga[$id]['tags'] = getTags($id);
        $allManga[$id]['authors'] = getMangaAuthors($id);
        $allManga[$id]['artists'] = getMangaArtists($id);
    }
}

// Get all manga for latest updates
try {
    $latestUpdates = getLatestUpdatedManga(12);
} catch (Exception $e) {
    // Fallback if there's an error
    $latestUpdates = [];
    for ($i = 1; $i <= 3; $i++) {
        if (isset($allManga[$i])) {
            $latestUpdates[] = $allManga[$i];
        }
    }
}

// For backward compatibility
$zeikinManga = $allManga[1] ?? null;

$pathPrefix = ''; // Define path prefix for includes relative to root

// --- Include the Homepage View ---
include __DIR__ . '/PHP/homepage.php';

?>
