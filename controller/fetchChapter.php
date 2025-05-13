<?php
require_once('../db/fetchChapter.php');

// Get JSON input from JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Extract chapterIDs from the request data
$chapterIDs =  array_reverse($data['chapterIDs']) ?? [];

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

// Return the chapter information as JSON
header('Content-Type: application/json');
echo json_encode($grouped);

?>