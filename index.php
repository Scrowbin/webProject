<?php
// webProject/index.php - Homepage Controller

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary base files
require_once __DIR__ . '/db/pdo.php';
require_once __DIR__ . '/db/mangaInfoPdo.php'; // Contains getMangaInfo, getTags, getMangaAuthors, getMangaArtists
require_once __DIR__ . '/db/latestUpdates_model.php'; // Contains getUpdates for latest manga chapters

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

// Get recently added manga
$recentlyAddedManga = getRecent(10); // Lấy 10 manga mới nhất

// Thêm thông tin tags, authors, artists cho các manga mới thêm vào
foreach ($recentlyAddedManga as $key => $manga) {
    $mangaID = $manga['MangaID'];
    $recentlyAddedManga[$key]['tags'] = getTags($mangaID);
    $recentlyAddedManga[$key]['authors'] = getMangaAuthors($mangaID);
    $recentlyAddedManga[$key]['artists'] = getMangaArtists($mangaID);
}

// Get latest manga updates using getAllLatestChapters function
try {
    // Lấy 12 chapter mới nhất
    $latestChapters = getAllLatestChapters(12, 0);

    // Tạo mảng để lưu trữ thông tin chapter
    $latestUpdates = [];

    // Xử lý từng chapter
    foreach ($latestChapters as $chapter) {
        $mangaID = $chapter['MangaID'];

        // Lấy số lượng comment cho chapter
        $commentData = getComments($chapter['ChapterID']);

        // Tạo thông tin chapter
        $chapterInfo = [
            'MangaID' => $mangaID,
            'MangaNameOG' => $chapter['MangaNameOG'],
            'CoverLink' => $chapter['CoverLink'],
            'ChapterID' => $chapter['ChapterID'],
            'ChapterNumber' => $chapter['ChapterNumber'],
            'ChapterName' => $chapter['ChapterName'],
            'UploadTime' => $chapter['UploadTime'],
            'ScangroupName' => $chapter['ScangroupName'],
            'NumOfComments' => $commentData['NumOfComments'] ?? 0
        ];

        // Thêm chapter vào danh sách latest updates
        $latestUpdates[] = $chapterInfo;
    }
} catch (Exception $e) {
    // Fallback if there's an error
    $latestUpdates = [];
    for ($i = 1; $i <= 3; $i++) {
        if (isset($allManga[$i])) {
            // Tạo một chapter giả cho mỗi manga
            $latestUpdates[] = [
                'MangaID' => $allManga[$i]['MangaID'],
                'MangaNameOG' => $allManga[$i]['MangaNameOG'],
                'CoverLink' => $allManga[$i]['CoverLink'],
                'ChapterID' => 1,
                'ChapterNumber' => 1,
                'ChapterName' => 'Chapter 1',
                'UploadTime' => date('Y-m-d H:i:s'),
                'ScangroupName' => 'Unknown',
                'NumOfComments' => 0
            ];
        }
    }
}

// For backward compatibility
$zeikinManga = $allManga[1] ?? null;

$pathPrefix = ''; // Define path prefix for includes relative to root

// --- Include the Homepage View ---
include __DIR__ . '/PHP/homepage.php';
