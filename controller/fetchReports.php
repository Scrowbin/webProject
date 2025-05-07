<?php
header('Content-Type: application/json');
require_once("../db/report_model.php");
$page = $_GET['page'] ?? 1; // if page is not set, default to 1

$limit = 5;
$offset = ($page - 1) * $limit;

//getreports
$mangaReports =  getMangaReports($limit,$offset);
$chapterReports =  getChapterReports($limit,$offset);

echo json_encode([
    'mangaReports' => $mangaReports,
    'chapterReports' => $chapterReports
]);