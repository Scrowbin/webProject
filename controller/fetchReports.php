<?php
header('Content-Type: application/json');
require_once("../db/report_model.php");

$page = $_GET['page'] ?? 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Fetch 1 extra item to check for more pages
$mangaReportsRaw = getMangaReports($limit + 1, $offset);
$chapterReportsRaw = getChapterReports($limit + 1, $offset);

// Determine if there are more items
$mangaHasMore = count($mangaReportsRaw) > $limit;
$chapterHasMore = count($chapterReportsRaw) > $limit;

// Slice to return only the current page's data
$mangaReports = array_slice($mangaReportsRaw, 0, $limit);
$chapterReports = array_slice($chapterReportsRaw, 0, $limit);

echo json_encode([
    'mangaReports' => $mangaReports,
    'chapterReports' => $chapterReports,
    'mangaHasMore' => $mangaHasMore,
    'chapterHasMore' => $chapterHasMore
]);
