<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary database access files
require_once __DIR__ . '/../db/pdo.php'; // Ensure pdo connection function is available
require_once __DIR__ . '/../db/mangaInfoPdo.php';
require_once __DIR__ . '/../db/LibraryAndRating.php'; // For bookmark and rating checks
require_once __DIR__ . '/../db/commentsPdo.php'; // For comment counts

// Get MangaID from query string
$mangaID = filter_input(INPUT_GET, 'mangaID', FILTER_VALIDATE_INT);

if (!$mangaID) {
    // Handle invalid or missing MangaID - redirect or show error page
    // header('Location: /error.php?code=invalid_manga_id');
    die("Invalid or missing MangaID.");
}

// Database connection
$pdo = pdo_get_connection();

// User session details
$username = $_SESSION['username'] ?? null;
$userID = $_SESSION['userID'] ?? null; // Assuming userID is stored in session upon login
$isLoggedIn = ($userID !== null && $username !== null);

// Fetch Manga Details
$mangaInfo = getMangaInfo($mangaID); // Removed $pdo
if (!$mangaInfo) {
    // Handle manga not found
    // header('Location: /error.php?code=manga_not_found');
    die("Manga not found.");
}

// Fetch related data
$authorsRaw = getMangaAuthors($mangaID); // Removed $pdo
$artistsRaw = getMangaArtists($mangaID); // Removed $pdo
$tags = getTags($mangaID); // Removed $pdo
$chapters = getChapters($mangaID); // Removed $pdo
$counts = getCommentCountsPerChapter($mangaID); // Removed $pdo

// Process comment counts
$countsMap = [];
foreach ($counts as $row) {
    $countsMap[$row['ChapterID']] = $row['NumOfComments'];
}

// Group chapters by volume and add comment counts
$grouped = [];
foreach ($chapters as $chapter) {
    $vol = $chapter['Volume'];
    // Add comment count to each chapter before grouping
    $chapter['NumOfComments'] = $countsMap[$chapter['ChapterID']] ?? 0;
    $grouped[$vol][] = $chapter;
}
// Sort volumes numerically if needed (keys might be strings like "1.0")
ksort($grouped, SORT_NUMERIC);

// Check bookmark and rating status if logged in
$isBookmarked = false;
$userRating = 0;
if ($isLoggedIn && $userID) {
    $isBookmarked = isBookmarked($userID, $mangaID); // Removed $pdo, ensure correct param order
    $userRating = getRating($userID, $mangaID); // Removed $pdo
} else {
    // Ensure rating is explicitly 0 for guests
    $userRating = 0;
}

// Include the view file, passing all necessary variables
include __DIR__ . '/../PHP/mangaInfo.php';
?>