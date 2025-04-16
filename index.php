<?php
// webProject/index.php - Homepage Controller

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary base files
require_once __DIR__ . '/db/pdo.php';
require_once __DIR__ . '/db/mangaInfoPdo.php'; // Contains getMangaInfo, getTags, getMangaAuthors, getMangaArtists

// --- Data Fetching for Homepage ---

// Fetch info for all manga (IDs 1, 2, and 3)
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

// For backward compatibility
$zeikinManga = $allManga[1];

$pathPrefix = ''; // Define path prefix for includes relative to root

// --- Include the Homepage View ---
include __DIR__ . '/PHP/homepage.php';

?>
