<?php
require_once '../db/commentsPdo.php'; // Your DB connection

$commentSectionID = $_GET['commentsID'];
$page = $_GET['page'] ?? 1; // if page is not set, default to 1

$limit = 5;
$offset = ($page - 1) * $limit;

$comments = getComments($commentSectionID,$limit,$offset);


// Fetch total count
$countResult = getCount($commentSectionID);
$total = getCount($commentSectionID);

echo json_encode([
    'comments' => $comments,
    'total' => $total
]);

?>