<?php

require_once __DIR__ . '/../models/pdo.php';
require_once __DIR__ . '/../models/mangaInfoPdo.php';
require_once __DIR__ . '/../models/latestUpdates_model.php';
require_once __DIR__ . '/../models/announcement_model.php';
require_once __DIR__ . '/../models/staff_picks_model.php';
require_once __DIR__ . '/../models/account_db.php';

$topRatedManga = getTopRatedManga(4, 1);

if (count($topRatedManga) < 4) {
    $defaultManga = [];
    $defaultManga[1] = getMangaInfo(1);
    $defaultManga[2] = getMangaInfo(2);
    $defaultManga[3] = getMangaInfo(3);

    for ($i = count($topRatedManga); $i < 4; $i++) {
        $defaultId = $i + 1;
        if (isset($defaultManga[$defaultId])) {
            $topRatedManga[] = $defaultManga[$defaultId];
        }
    }
}

$allManga = [];
foreach ($topRatedManga as $manga) {
    $mangaId = $manga['MangaID'];
    $allManga[$mangaId] = $manga;
    $allManga[$mangaId]['tags'] = getTags($mangaId);
    $allManga[$mangaId]['authors'] = getMangaAuthors($mangaId);
    $allManga[$mangaId]['artists'] = getMangaArtists($mangaId);

    if (isset($manga['AvgRating'])) {
        $allManga[$mangaId]['AvgRating'] = round($manga['AvgRating'], 1);
        $allManga[$mangaId]['RatingCount'] = $manga['RatingCount'];
    }
}

$recentlyAddedManga = getRecent(10);

foreach ($recentlyAddedManga as $key => $manga) {
    $mangaID = $manga['MangaID'];
    $recentlyAddedManga[$key]['tags'] = getTags($mangaID);
    $recentlyAddedManga[$key]['authors'] = getMangaAuthors($mangaID);
    $recentlyAddedManga[$key]['artists'] = getMangaArtists($mangaID);
}

$staffPicksManga = getStaffPicks(10);

try {
    $latestChapters = getUpdates(1000, 0);

    foreach ($latestChapters as &$chapter) {
        $commentData = getComments($chapter['ChapterID']);
        $chapter['NumOfComments'] = $commentData['NumOfComments'] ?? 0;
        $chapter['CommentSectionID'] = $commentData['CommentSectionID'] ?? 0;
    }

    usort($latestChapters, function ($a, $b) {
        return strtotime($b['UploadTime']) - strtotime($a['UploadTime']);
    });

    $latestChapters = array_slice($latestChapters, 0, 24);

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
                'Language' => $chapter['Language'] ?? 'English',
            ],
        ];
    }
} catch (Exception $e) {
    $latestUpdates = [];
    for ($i = 1; $i <= 3; $i++) {
        if (isset($allManga[$i])) {
            $latestUpdates[] = $allManga[$i];
        }
    }
}

$zeikinManga = $allManga[1] ?? null;
$activeAnnouncement = getLatestActiveAnnouncement();

$userID = $_SESSION['userID'] ?? null;
$username = $_SESSION['username'] ?? null;
$isLoggedIn = isset($_SESSION['userID']);
$role = 'user';
if ($isLoggedIn) {
    $role = get_role($userID);
}

$pathPrefix = '';

include __DIR__ . '/../views/homepage.php';
