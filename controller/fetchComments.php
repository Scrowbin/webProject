<?php
require_once '../db/pdo.php'; // Your DB connection

$mangaID = $_GET['mangaID'];
$page = $_GET['page'];
$limit = 5;
$offset = ($page - 1) * $limit;

$comments = pdo_query(
    'SELECT * FROM comments WHERE MangaID = ? ORDER BY CreatedAt DESC LIMIT ? OFFSET ?',
    $mangaID, $limit, $offset
);

echo json_encode($comments);
?>