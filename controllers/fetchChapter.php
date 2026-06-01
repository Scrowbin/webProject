<?php

require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../models/fetchChapter.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!is_array($data)) {
    echo json_encode([]);
    exit;
}

$chapterIDs = array_reverse($data['chapterIDs'] ?? []);

// Prepare an array to hold the chapter info
$chapters = getChapterInfo($chapterIDs);
$grouped = [];
$currentGroupIndex = -1;

foreach ($chapters as $index => $chapter) {
    $mangaID = $chapter['MangaID'];

    // Add extra info
    $commentSectionID = getCommentSectionID($chapter['ChapterID']);
    $chapter['CommentSectionID'] = $commentSectionID ?? 0;
    $chapter['NumOfComments'] = getNumOfComment($commentSectionID) ?? 0;

    if ($index === 0 || $chapters[$index - 1]['MangaID'] !== $mangaID) {
        $currentGroupIndex++;
    }
    $grouped[$currentGroupIndex][] = $chapter;
}

echo json_encode($grouped);

?>