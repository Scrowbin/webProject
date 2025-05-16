<?php
// webProject/index.php - Homepage Controller

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary base files
require_once __DIR__ . '/db/pdo.php';
require_once __DIR__ . '/db/mangaInfoPdo.php'; // Contains getMangaInfo, getTags, getMangaAuthors, getMangaArtists
require_once __DIR__ . '/db/latestUpdates_model.php'; // Contains getUpdates for latest manga chapters
require_once __DIR__ . '/db/announcement_model.php'; // Contains announcement functions
require_once __DIR__ . '/db/staff_picks_model.php'; // Contains staff picks functions
require_once __DIR__ . '/db/account_db.php'; // For user role functions

// --- Data Fetching for Homepage ---

// Get top-rated manga for the Popular New Titles carousel
$topRatedManga = getTopRatedManga(4, 1); // Get top 4 manga with at least 1 rating

// If we don't have enough top-rated manga, fall back to some default manga
if (count($topRatedManga) < 4) {
    // Simplified approach to avoid SQL errors
    $defaultManga = [];

    // Fetch manga with ID 1 (Zeikin de Katta Hon)
    $defaultManga[1] = getMangaInfo(1);

    // Fetch manga with ID 2 (Kaoru Hana wa Rin to Saku)
    $defaultManga[2] = getMangaInfo(2);

    // Fetch manga with ID 3 (Sousou no Frieren)
    $defaultManga[3] = getMangaInfo(3);

    // Fill in any missing slots with default manga
    for ($i = count($topRatedManga); $i < 4; $i++) {
        $defaultId = $i + 1;
        if (isset($defaultManga[$defaultId])) {
            $topRatedManga[] = $defaultManga[$defaultId];
        }
    }
}

// Format the manga array for the carousel
$allManga = [];
foreach ($topRatedManga as $index => $manga) {
    $mangaId = $manga['MangaID'];
    $allManga[$mangaId] = $manga;

    // Add additional information
    $allManga[$mangaId]['tags'] = getTags($mangaId);
    $allManga[$mangaId]['authors'] = getMangaAuthors($mangaId);
    $allManga[$mangaId]['artists'] = getMangaArtists($mangaId);

    // Add rating information if available
    if (isset($manga['AvgRating'])) {
        $allManga[$mangaId]['AvgRating'] = round($manga['AvgRating'], 1);
        $allManga[$mangaId]['RatingCount'] = $manga['RatingCount'];
    }
}

// Get recently added manga
$recentlyAddedManga = getRecent(10); // Lấy 10 manga mới nhất

// Thêm thông tin tags, authors, artists cho các manga mới thêm vào
foreach ($recentlyAddedManga as $key => $manga) {
    $mangaID = $manga['MangaID'];
    $recentlyAddedManga[$key]['tags'] = getTags($mangaID);
    $recentlyAddedManga[$key]['authors'] = getMangaAuthors($mangaID);
    $recentlyAddedManga[$key]['artists'] = getMangaArtists($mangaID);
}

// Get staff picks for the Staff Picks carousel
$staffPicksManga = getStaffPicks(10); // Get up to 10 staff picks

// Get latest manga updates using getUpdates function - similar to latestUpdates_controller.php
try {
    // Get a large number of recent chapters to ensure we have enough
    $latestChapters = getUpdates(1000, 0);

    // Process each chapter to add comment data
    foreach ($latestChapters as &$chapter) {
        $commentData = getComments($chapter['ChapterID']);
        $chapter['NumOfComments'] = $commentData["NumOfComments"] ?? 0;
        $chapter['CommentSectionID'] = $commentData["CommentSectionID"] ?? 0;
    }

    // Sort all chapters by upload time (most recent first)
    usort($latestChapters, function($a, $b) {
        return strtotime($b['UploadTime']) - strtotime($a['UploadTime']);
    });

    // Take only the first 24 chapters (or less if there aren't enough)
    // This will allow us to display 6 chapters in each of the 4 columns
    $latestChapters = array_slice($latestChapters, 0, 24);

    // Format the chapters for display
    $latestUpdates = [];
    foreach ($latestChapters as $chapter) {
        $latestUpdates[] = [
            'MangaID' => $chapter['MangaID'],
            'MangaSlug' => $chapter['Slug'],
            'MangaNameOG' => $chapter['MangaNameOG'],
            'CoverLink' => $chapter['CoverLink'],
            'Chapter' => [
                'ChapterID' => $chapter['ChapterID'],
                'ChapterNumber' => $chapter['ChapterNumber'],
                'ChapterName' => $chapter['ChapterName'],
                'UploadTime' => $chapter['UploadTime'],
                'ScangroupName' => $chapter['ScangroupName'],
                'NumOfComments' => $chapter['NumOfComments'] ?? 0,
                'Language' => $chapter['Language'] ?? "English",
            ]
        ];
    }
    // var_dump($chapter); // check if 'Slug' exists

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

// Get latest active announcement for initial load
// (AJAX will handle updates after page load)
$activeAnnouncement = getLatestActiveAnnouncement();

// Get user role for sidebar display
$userID = $_SESSION['userID'] ?? null;
$username = $_SESSION['username'] ?? null;
$isLoggedIn = isset($_SESSION['userID']);
$role = "user";
if ($isLoggedIn) {
    $role = get_role($userID);
}

$pathPrefix = ''; // Define path prefix for includes relative to root

// --- Include the Homepage View ---
include __DIR__ . '/PHP/homepage.php';
